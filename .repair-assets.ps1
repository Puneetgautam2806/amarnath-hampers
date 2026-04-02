$ErrorActionPreference = 'Stop'
$root = (Get-Location).Path
$priority = @{
  img   = @('.jpg','.jpeg','.png','.webp','.svg','.gif')
  js    = @('.js')
  css   = @('.css')
  fonts = @('.woff2','.woff','.ttf','.eot')
}
$changedFiles = 0
$totalBefore = 0
$totalAfter = 0
$unresolved = New-Object System.Collections.Generic.List[string]

Get-ChildItem -Path $root -File -Filter *.html | ForEach-Object {
  $file = $_.FullName
  $content = Get-Content -Path $file -Raw -ErrorAction SilentlyContinue
  if ([string]::IsNullOrEmpty($content)) { return }

  $original = $content
  $before = ([regex]::Matches($content, 'assets/[^"''\)\s>]+\.html')).Count
  if ($before -eq 0) { return }
  $totalBefore += $before

  $refs = [regex]::Matches($content, 'assets/[^"''\)\s>]+\.html') | ForEach-Object { $_.Value } | Select-Object -Unique
  foreach ($ref in $refs) {
    $assetPath = Join-Path $root ($ref -replace '/', '\\')
    $assetDir = Split-Path -Path $assetPath -Parent
    $base = [System.IO.Path]::GetFileNameWithoutExtension($assetPath)

    if (-not (Test-Path -Path $assetDir)) {
      $unresolved.Add("$($_.Name): $ref") | Out-Null
      continue
    }

    $candidates = Get-ChildItem -Path $assetDir -File | Where-Object {
      [System.IO.Path]::GetFileNameWithoutExtension($_.Name) -eq $base -and $_.Extension.ToLower() -ne '.html'
    }

    if (-not $candidates -or $candidates.Count -eq 0) {
      $unresolved.Add("$($_.Name): $ref") | Out-Null
      continue
    }

    $bucket = if ($ref -like 'assets/img/*') { 'img' } elseif ($ref -like 'assets/js/*') { 'js' } elseif ($ref -like 'assets/css/*') { 'css' } elseif ($ref -like 'assets/fonts/*') { 'fonts' } else { $null }
    $chosen = $null

    if ($bucket -and $priority.ContainsKey($bucket)) {
      foreach ($ext in $priority[$bucket]) {
        $hit = $candidates | Where-Object { $_.Extension.ToLower() -eq $ext } | Select-Object -First 1
        if ($hit) { $chosen = $hit; break }
      }
    }

    if (-not $chosen) { $chosen = $candidates | Select-Object -First 1 }

    $newRef = $ref -replace '\.html$', $chosen.Extension.ToLower()
    if ($newRef -ne $ref) {
      $content = $content.Replace($ref, $newRef)
    }
  }

  if ($content -ne $original) {
    Set-Content -Path $file -Value $content -NoNewline
    $changedFiles++
  }

  $after = ([regex]::Matches($content, 'assets/[^"''\)\s>]+\.html')).Count
  $totalAfter += $after
}

$unresolved | Select-Object -Unique | Set-Content -Path '.asset-unresolved.txt'
"Changed files: $changedFiles"
"Asset refs before run: $totalBefore"
"Asset refs after run:  $totalAfter"
"Resolved this run:    $($totalBefore - $totalAfter)"
"Unresolved unique:    $((Get-Content '.asset-unresolved.txt').Count)"