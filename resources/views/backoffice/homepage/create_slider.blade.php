@extends('backoffice.master_layout')

@section('title', 'Add Banner Slide')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">
            <form action="{{ route('homepage.storeSlider') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card mb-6" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom py-4">
                        <div>
                            <h4 class="mb-0 text-dark fw-bold">Add Banner Slide</h4>
                            <span class="text-muted small">Create a new hero slide with customizable typography, position, and button styles</span>
                        </div>
                        <a href="{{ route('homepage.index', ['tab' => 'sliders']) }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 8px;">
                            <i class="bx bx-left-arrow-alt me-1"></i> Back to Sliders
                        </a>
                    </div>
                    
                    <div class="card-body pt-5">
                        
                        <!-- Top Row: Background Image + Live Preview -->
                        <div class="row g-4 mb-5">
                            <!-- Background Graphic Upload -->
                            <div class="col-lg-5">
                                <label class="form-label fw-bold text-secondary mb-2">Background Graphic (Required)</label>
                                <div class="p-3 rounded text-center d-flex flex-column align-items-center justify-content-center position-relative" style="background-color: #f8f9fa; border: 2px dashed #d9dee3; height: 210px; border-radius: 12px; cursor: pointer;">
                                    <div class="image-preview-container-modal w-100 h-100 d-flex flex-column align-items-center justify-content-center" id="image-preview">
                                        <i class="bx bx-cloud-upload text-muted mb-2" style="font-size: 3rem;"></i>
                                        <span class="text-secondary small fw-bold">Click to Upload Banner Image</span>
                                    </div>
                                    <input class="form-control position-absolute opacity-0" type="file" name="image" id="image" accept="image/*" required onchange="previewFile()" style="height: 100%; width: 100%; cursor: pointer; top:0; left:0; z-index: 10;">
                                </div>
                                <span class="text-muted small d-block mt-2 text-center">Click box to upload banner photo (JPG, PNG, WEBP).</span>
                            </div>

                            <!-- Live Simulation Preview Canvas -->
                            <div class="col-lg-7">
                                <label class="form-label fw-bold text-secondary mb-2 d-flex justify-content-between">
                                    <span><i class="bx bx-show text-primary me-1"></i> Live Layout & Style Preview</span>
                                    <small class="text-muted">Simulates frontend appearance</small>
                                </label>
                                <div id="liveBannerCanvas" class="rounded p-4 position-relative overflow-hidden d-flex align-items-center" style="height: 210px; border-radius: 12px; background-size: cover; background-position: center; background-color: #2b2d42;">
                                    <div id="liveBannerOverlay" class="position-absolute w-100 h-100" style="top:0; left:0; background: rgba(0,0,0, 0); z-index: 1;"></div>
                                    <div id="liveBannerContent" class="w-100 position-relative" style="z-index: 2;">
                                        <div id="liveSubtitle" class="d-inline-block small px-2 py-1 mb-1 fw-bold" style="font-size: 0.72rem; border-radius: 12px; color: #ffffff; background-color: #ff7c8b; display: none;">Subtitle Badge</div>
                                        <h5 id="liveTitle" class="fw-bold mb-1" style="color: #ffffff; font-size: 1.15rem; line-height: 1.2; display: none;">Slide Title</h5>
                                        <p id="liveDesc" class="small mb-2" style="color: #e2e8f0; font-size: 0.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; display: none;">Description text preview</p>
                                        <div id="liveButtons" class="d-flex gap-2 align-items-center">
                                            <span id="liveBtn1" class="btn btn-xs fw-bold px-3 py-1" style="border-radius: 20px; font-size: 0.75rem; display: none;">Button 1</span>
                                            <span id="liveBtn2" class="btn btn-xs fw-bold px-3 py-1" style="border-radius: 20px; font-size: 0.75rem; display: none;">Button 2</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- SECTION 1: Banner Position & Alignment Settings -->
                        <div class="p-4 bg-light rounded-3 mb-5 border" style="border-radius: 12px;">
                            <h6 class="fw-bold text-dark mb-3"><i class="bx bx-layout text-primary me-2"></i> Banner Position & Readability</h6>
                            <div class="row g-3">
                                <!-- Content Position (Left, Center, Right) -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-dark" for="content_position">Text & Button Position on Banner</label>
                                    <select class="form-select" id="content_position" name="content_position" onchange="updateLivePreview()">
                                        <option value="left" selected>⬅️ Left Aligned (Default)</option>
                                        <option value="center">⏺️ Center / Middle</option>
                                        <option value="right">➡️ Right Aligned</option>
                                    </select>
                                    <small class="text-muted d-block mt-1">Controls where content block sits on desktop & mobile</small>
                                </div>

                                <!-- Text Alignment -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-dark" for="text_align">Text Alignment</label>
                                    <select class="form-select" id="text_align" name="text_align" onchange="updateLivePreview()">
                                        <option value="left" selected>Left Text</option>
                                        <option value="center">Center Text</option>
                                        <option value="right">Right Text</option>
                                    </select>
                                    <small class="text-muted d-block mt-1">Justification of heading, text, and buttons</small>
                                </div>

                                <!-- Background Shade / Overlay Opacity -->
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-dark" for="overlay_opacity">Dark Readability Shade / Tint</label>
                                    <select class="form-select" id="overlay_opacity" name="overlay_opacity" onchange="updateLivePreview()">
                                        <option value="0" selected>0% (No Dark Tint)</option>
                                        <option value="20">20% (Subtle Light Tint)</option>
                                        <option value="40">40% (Medium Tint - Recommended)</option>
                                        <option value="60">60% (Strong Dark Tint)</option>
                                    </select>
                                    <small class="text-muted d-block mt-1">Darkens bright photos to ensure text is easily readable</small>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: Slide Text & Color Customization -->
                        <div class="mb-5">
                            <h6 class="fw-bold text-dark mb-3"><i class="bx bx-font text-warning me-2"></i> Slide Text & Typography Colors</h6>
                            
                            <!-- Slide Title -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold" for="title">Slide Title <span class="badge bg-label-secondary text-muted fw-normal ms-1">Optional</span></label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-heading"></i></span>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Elegant Corporate Hampers" oninput="updateLivePreview()">
                                    </div>
                                    <span class="text-muted small d-block mt-1">Main banner text. Leave blank if your banner graphic already contains text.</span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold" for="title_color">Title Text Color</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color" id="title_color_picker" value="{{ old('title_color', '#ffffff') }}" style="width: 48px; padding: 4px;" onchange="syncColorInput('title_color', this.value)">
                                        <input type="text" class="form-control" id="title_color" name="title_color" value="{{ old('title_color', '#ffffff') }}" placeholder="#ffffff" oninput="syncColorPicker('title_color_picker', this.value)">
                                    </div>
                                    <div class="mt-1 d-flex gap-1">
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2" onclick="setFastColor('title_color', 'title_color_picker', '#ffffff')">White</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2" onclick="setFastColor('title_color', 'title_color_picker', '#222222')">Dark</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2" onclick="setFastColor('title_color', 'title_color_picker', '#ff7c8b')">Pink</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2" onclick="setFastColor('title_color', 'title_color_picker', '#cf9b13')">Gold</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Subtitle & Colors -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold" for="subtitle">Subtitle / Category Badge</label>
                                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" placeholder="e.g. Exclusive Hamper" oninput="updateLivePreview()">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold" for="subtitle_color">Badge Text Color</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color" id="subtitle_color_picker" value="{{ old('subtitle_color', '#ffffff') }}" style="width: 44px; padding: 4px;" onchange="syncColorInput('subtitle_color', this.value)">
                                        <input type="text" class="form-control" id="subtitle_color" name="subtitle_color" value="{{ old('subtitle_color', '#ffffff') }}" placeholder="#ffffff" oninput="syncColorPicker('subtitle_color_picker', this.value)">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold" for="subtitle_bg">Badge Background</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color" id="subtitle_bg_picker" value="{{ old('subtitle_bg', '#ff7c8b') }}" style="width: 44px; padding: 4px;" onchange="syncColorInput('subtitle_bg', this.value)">
                                        <input type="text" class="form-control" id="subtitle_bg" name="subtitle_bg" value="{{ old('subtitle_bg', '#ff7c8b') }}" placeholder="#ff7c8b" oninput="syncColorPicker('subtitle_bg_picker', this.value)">
                                    </div>
                                </div>
                            </div>

                            <!-- Description Text & Color -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold" for="description">Description / Paragraph Text</label>
                                    <textarea class="form-control" id="description" name="description" rows="2" placeholder="Brief description to capture customer interest..." oninput="updateLivePreview()">{{ old('description') }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold" for="description_color">Description Text Color</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color" id="description_color_picker" value="{{ old('description_color', '#e2e8f0') }}" style="width: 48px; padding: 4px;" onchange="syncColorInput('description_color', this.value)">
                                        <input type="text" class="form-control" id="description_color" name="description_color" value="{{ old('description_color', '#e2e8f0') }}" placeholder="#e2e8f0" oninput="syncColorPicker('description_color_picker', this.value)">
                                    </div>
                                    <div class="mt-1 d-flex gap-1">
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2" onclick="setFastColor('description_color', 'description_color_picker', '#ffffff')">White</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2" onclick="setFastColor('description_color', 'description_color_picker', '#e2e8f0')">Light Gray</button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2" onclick="setFastColor('description_color', 'description_color_picker', '#333333')">Dark Gray</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- SECTION 3: Action Buttons & Style Presets -->
                        <div class="mb-5">
                            <h6 class="fw-bold text-dark mb-3"><i class="bx bx-mouse text-success me-2"></i> Call-to-Action Buttons & Colors</h6>
                            
                            <div class="row g-4">
                                <!-- Button 1 (Primary Action) -->
                                <div class="col-md-6 border-end">
                                    <div class="p-3 bg-light rounded-3 border h-100">
                                        <h6 class="text-primary fw-bold mb-3 small"><i class="bx bx-link me-1"></i> Button 1 (Primary Action)</h6>
                                        
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Button 1 Text</label>
                                            <input type="text" class="form-control" id="btn1_text" name="btn1_text" value="{{ old('btn1_text') }}" placeholder="e.g. Shop Now" oninput="updateLivePreview()">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Button 1 Link / URL</label>
                                            <input type="text" class="form-control" name="btn1_link" value="{{ old('btn1_link') }}" placeholder="e.g. /shop or https://...">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold" for="btn1_style">Button 1 Style Theme</label>
                                            <select class="form-select" id="btn1_style" name="btn1_style" onchange="onBtn1StyleChange(this.value)">
                                                <option value="theme-primary" selected>🌸 Theme Rose Pink Solid (Default)</option>
                                                <option value="dark-solid">🖤 Charcoal Black Solid</option>
                                                <option value="white-solid">🤍 Crisp White Solid (Dark Text)</option>
                                                <option value="gold-solid">👑 Royal Gold Solid</option>
                                                <option value="outline-pink">⭕ Pink Border Outline</option>
                                                <option value="outline-white">⚪ White Border Outline</option>
                                                <option value="outline-dark">⚫ Dark Border Outline</option>
                                                <option value="custom">🎨 Custom Colors (Specify Below)</option>
                                            </select>
                                        </div>

                                        <!-- Custom Button 1 Colors -->
                                        <div id="btn1_custom_colors_wrap" class="row g-2 d-none">
                                            <div class="col-6">
                                                <label class="form-label extra-small fw-semibold">Custom Background</label>
                                                <input type="text" class="form-control form-control-sm" id="btn1_bg_color" name="btn1_bg_color" value="{{ old('btn1_bg_color') }}" placeholder="#ff7c8b" oninput="updateLivePreview()">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label extra-small fw-semibold">Custom Text Color</label>
                                                <input type="text" class="form-control form-control-sm" id="btn1_text_color" name="btn1_text_color" value="{{ old('btn1_text_color') }}" placeholder="#ffffff" oninput="updateLivePreview()">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Button 2 (Secondary Action) -->
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3 border h-100">
                                        <h6 class="text-success fw-bold mb-3 small"><i class="bx bx-link me-1"></i> Button 2 (Secondary Action)</h6>
                                        
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Button 2 Text</label>
                                            <input type="text" class="form-control" id="btn2_text" name="btn2_text" value="{{ old('btn2_text') }}" placeholder="e.g. View Details" oninput="updateLivePreview()">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Button 2 Link / URL</label>
                                            <input type="text" class="form-control" name="btn2_link" value="{{ old('btn2_link') }}" placeholder="e.g. /about or #...">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold" for="btn2_style">Button 2 Style Theme</label>
                                            <select class="form-select" id="btn2_style" name="btn2_style" onchange="onBtn2StyleChange(this.value)">
                                                <option value="theme-outline" selected>🌸 Theme Rose Pink Outline (Default)</option>
                                                <option value="white-outline">⚪ White Border Outline</option>
                                                <option value="dark-outline">⚫ Dark Border Outline</option>
                                                <option value="theme-primary">🌸 Theme Rose Pink Solid</option>
                                                <option value="dark-solid">🖤 Charcoal Black Solid</option>
                                                <option value="white-solid">🤍 Crisp White Solid (Dark Text)</option>
                                                <option value="gold-solid">👑 Royal Gold Solid</option>
                                                <option value="custom">🎨 Custom Colors (Specify Below)</option>
                                            </select>
                                        </div>

                                        <!-- Custom Button 2 Colors -->
                                        <div id="btn2_custom_colors_wrap" class="row g-2 d-none">
                                            <div class="col-6">
                                                <label class="form-label extra-small fw-semibold">Custom Background</label>
                                                <input type="text" class="form-control form-control-sm" id="btn2_bg_color" name="btn2_bg_color" value="{{ old('btn2_bg_color') }}" placeholder="transparent" oninput="updateLivePreview()">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label extra-small fw-semibold">Custom Text Color</label>
                                                <input type="text" class="form-control form-control-sm" id="btn2_text_color" name="btn2_text_color" value="{{ old('btn2_text_color') }}" placeholder="#ffffff" oninput="updateLivePreview()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: Status & Ordering -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" for="orders">Display Sort Order</label>
                                <input type="number" class="form-control" id="orders" name="orders" value="{{ old('orders', 0) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold" for="status">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active (Visible on Frontend)</option>
                                    <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Inactive (Draft / Hidden)</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    
                    <div class="card-footer border-top py-4 px-5 text-end" style="background: #f8f9fa; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                        <a href="{{ route('homepage.index', ['tab' => 'sliders']) }}" class="btn btn-outline-secondary px-4 me-2" style="border-radius: 8px;">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold" style="border-radius: 8px;"><i class="bx bx-check-circle me-1"></i> Save Banner Slide</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewFile() {
    const file = document.getElementById('image').files[0];
    const reader = new FileReader();

    reader.addEventListener("load", function () {
        document.getElementById('image-preview').innerHTML = `<img src="${reader.result}" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: cover; border-radius: 8px;">`;
        document.getElementById('liveBannerCanvas').style.backgroundImage = "url('" + reader.result + "')";
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}

function syncColorInput(targetId, colorVal) {
    document.getElementById(targetId).value = colorVal;
    updateLivePreview();
}

function syncColorPicker(pickerId, hexVal) {
    if (/^#[0-9A-F]{6}$/i.test(hexVal)) {
        document.getElementById(pickerId).value = hexVal;
    }
    updateLivePreview();
}

function setFastColor(inputId, pickerId, hexVal) {
    document.getElementById(inputId).value = hexVal;
    document.getElementById(pickerId).value = hexVal;
    updateLivePreview();
}

function onBtn1StyleChange(style) {
    var wrap = document.getElementById('btn1_custom_colors_wrap');
    if (style === 'custom') {
        wrap.classList.remove('d-none');
    } else {
        wrap.classList.add('d-none');
    }
    updateLivePreview();
}

function onBtn2StyleChange(style) {
    var wrap = document.getElementById('btn2_custom_colors_wrap');
    if (style === 'custom') {
        wrap.classList.remove('d-none');
    } else {
        wrap.classList.add('d-none');
    }
    updateLivePreview();
}

function updateLivePreview() {
    var pos = document.getElementById('content_position').value;
    var align = document.getElementById('text_align').value;
    var overlay = parseInt(document.getElementById('overlay_opacity').value) || 0;

    var title = document.getElementById('title').value;
    var titleColor = document.getElementById('title_color').value || '#ffffff';

    var subtitle = document.getElementById('subtitle').value;
    var subtitleColor = document.getElementById('subtitle_color').value || '#ffffff';
    var subtitleBg = document.getElementById('subtitle_bg').value || '#ff7c8b';

    var desc = document.getElementById('description').value;
    var descColor = document.getElementById('description_color').value || '#e2e8f0';

    var btn1Text = document.getElementById('btn1_text').value;
    var btn1Style = document.getElementById('btn1_style').value;
    var btn2Text = document.getElementById('btn2_text').value;
    var btn2Style = document.getElementById('btn2_style').value;

    // 1. Overlay
    document.getElementById('liveBannerOverlay').style.backgroundColor = 'rgba(0,0,0,' + (overlay/100) + ')';

    // 2. Alignment & Position
    var contentElem = document.getElementById('liveBannerContent');
    contentElem.style.textAlign = align;
    var btnsContainer = document.getElementById('liveButtons');
    btnsContainer.style.justifyContent = align === 'center' ? 'center' : (align === 'right' ? 'flex-end' : 'flex-start');

    // 3. Subtitle
    var subElem = document.getElementById('liveSubtitle');
    if (subtitle) {
        subElem.innerText = subtitle;
        subElem.style.color = subtitleColor;
        subElem.style.backgroundColor = subtitleBg;
        subElem.style.display = 'inline-block';
    } else {
        subElem.style.display = 'none';
    }

    // 4. Title
    var titleElem = document.getElementById('liveTitle');
    if (title) {
        titleElem.innerText = title.replace(/<[^>]*>?/gm, '');
        titleElem.style.color = titleColor;
        titleElem.style.display = 'block';
    } else {
        titleElem.innerText = '';
        titleElem.style.display = 'none';
    }

    // 5. Description
    var descElem = document.getElementById('liveDesc');
    if (desc) {
        descElem.innerText = desc;
        descElem.style.color = descColor;
        descElem.style.display = '-webkit-box';
    } else {
        descElem.style.display = 'none';
    }

    // 6. Buttons
    var b1 = document.getElementById('liveBtn1');
    if (btn1Text) {
        b1.innerText = btn1Text;
        b1.style.display = 'inline-block';
        applyBtnStyle(b1, btn1Style, document.getElementById('btn1_bg_color').value, document.getElementById('btn1_text_color').value);
    } else {
        b1.style.display = 'none';
    }

    var b2 = document.getElementById('liveBtn2');
    if (btn2Text) {
        b2.innerText = btn2Text;
        b2.style.display = 'inline-block';
        applyBtnStyle(b2, btn2Style, document.getElementById('btn2_bg_color').value, document.getElementById('btn2_text_color').value);
    } else {
        b2.style.display = 'none';
    }
}

function applyBtnStyle(elem, style, customBg, customText) {
    elem.style.backgroundColor = '';
    elem.style.color = '';
    elem.style.borderColor = '';
    elem.style.border = '1px solid transparent';

    switch(style) {
        case 'theme-primary':
            elem.style.backgroundColor = '#ff7c8b';
            elem.style.color = '#ffffff';
            break;
        case 'dark-solid':
            elem.style.backgroundColor = '#1a1a1a';
            elem.style.color = '#ffffff';
            break;
        case 'white-solid':
            elem.style.backgroundColor = '#ffffff';
            elem.style.color = '#1a1a1a';
            break;
        case 'gold-solid':
            elem.style.backgroundColor = '#cf9b13';
            elem.style.color = '#ffffff';
            break;
        case 'theme-outline':
        case 'outline-pink':
            elem.style.backgroundColor = 'transparent';
            elem.style.border = '1px solid #ff7c8b';
            elem.style.color = '#ff7c8b';
            break;
        case 'outline-white':
        case 'white-outline':
            elem.style.backgroundColor = 'transparent';
            elem.style.border = '1px solid #ffffff';
            elem.style.color = '#ffffff';
            break;
        case 'outline-dark':
        case 'dark-outline':
            elem.style.backgroundColor = 'transparent';
            elem.style.border = '1px solid #1a1a1a';
            elem.style.color = '#1a1a1a';
            break;
        case 'custom':
            elem.style.backgroundColor = customBg || '#ff7c8b';
            elem.style.color = customText || '#ffffff';
            elem.style.border = '1px solid ' + (customBg || '#ff7c8b');
            break;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updateLivePreview();
});
</script>
@endsection
