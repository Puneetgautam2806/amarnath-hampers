@extends('backoffice.master_layout')

@section('title', 'Homepage Manager')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

    <div class="d-flex justify-content-between align-items-center mb-6">
        <h4 class="mb-0">Homepage Manager</h4>
        <span class="text-muted small">Manage all frontend elements in a single module</span>
    </div>

    <!-- Tabs Container -->
    <div class="nav-align-top mb-6">
        <ul class="nav nav-tabs nav-fill" role="tablist" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <li class="nav-item">
                <button type="button" class="nav-link {{ request('tab') !== 'sliders' ? 'active' : '' }}" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-settings" aria-controls="navs-justified-settings" aria-selected="true" style="font-weight: 600; padding: 16px;">
                    <i class="bx bx-cog me-2"></i> General & Contact Settings
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link {{ request('tab') === 'sliders' ? 'active' : '' }}" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-sliders" aria-controls="navs-justified-sliders" aria-selected="false" style="font-weight: 600; padding: 16px;">
                    <i class="bx bx-images me-2"></i> Hero Banner Sliders
                </button>
            </li>
        </ul>
        
        <div class="tab-content" style="background: transparent; padding: 0; border: none; box-shadow: none;">
            
            <!-- Tab 1: General Settings -->
            <div class="tab-pane fade {{ request('tab') !== 'sliders' ? 'show active' : '' }}" id="navs-justified-settings" role="tabpanel">
                <form action="{{ route('homepage.updateSettings') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-4">
                        <!-- branding & essential contacts in a beautiful master card -->
                        <div class="col-12">
                            <div class="card mb-6" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                                <div class="card-header border-bottom py-4">
                                    <h5 class="mb-0 text-dark" style="font-weight: 700;">General Store Settings</h5>
                                </div>
                                <div class="card-body pt-6">
                                    
                                    <!-- Branding Uploads -->
                                    <div class="row mb-6">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-secondary mb-2" for="logo">Site Logo</label>
                                            <div class="d-flex align-items-center gap-4 p-3 rounded" style="background-color: #f8f9fa; border: 1px dashed #d9dee3;">
                                                <div class="logo-preview-container" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background: white; border-radius: 8px; border: 1px solid #e9ecef; overflow: hidden; padding: 5px;">
                                                    @if($settings?->logo_path)
                                                        <img src="{{ asset($settings->logo_path) }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                    @else
                                                        <img src="{{ asset('frontend/assets/img/logo/logo1.png') }}" alt="Default Logo" style="max-width: 100%; max-height: 100%; object-fit: contain; opacity: 0.5;">
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input class="form-control" type="file" name="logo" id="logo" accept="image/*">
                                                    <span class="text-muted small d-block mt-1">Recommended: 160x50px, PNG format</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-secondary mb-2" for="favicon">Site Favicon</label>
                                            <div class="d-flex align-items-center gap-4 p-3 rounded" style="background-color: #f8f9fa; border: 1px dashed #d9dee3;">
                                                <div class="favicon-preview-container" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; background: white; border-radius: 8px; border: 1px solid #e9ecef; overflow: hidden; padding: 5px;">
                                                    @if($settings?->favicon_path)
                                                        <img src="{{ asset($settings->favicon_path) }}" alt="Favicon" style="max-width: 32px; max-height: 32px; object-fit: contain;">
                                                    @else
                                                        <img src="{{ asset('frontend/assets/img/logo/logo4.png') }}" alt="Default Favicon" style="max-width: 32px; max-height: 32px; object-fit: contain; opacity: 0.5;">
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input class="form-control" type="file" name="favicon" id="favicon" accept="image/*">
                                                    <span class="text-muted small d-block mt-1">Recommended: 32x32px, ICO or PNG</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-6">

                                    <!-- Contacts Details -->
                                    <div class="form-section-title mb-4" style="font-weight: 700; color: #435ebe; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px;">Primary Contact Channels</div>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label" for="phone">Public Hotline / Phone</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $settings?->phone) }}" placeholder="e.g. +91 98765 43210">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="whatsapp">WhatsApp Business Number</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text text-success"><i class="bx bxl-whatsapp"></i></span>
                                                <input type="text" class="form-control" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $settings?->whatsapp) }}" placeholder="e.g. +919876543210">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="email">Public Contact Email</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $settings?->email) }}" placeholder="e.g. contact@amarnathhampers.com">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Collapsible Trigger Button for Advanced General Settings -->
                                    <div class="mt-5 mb-2 text-center">
                                        <button class="btn btn-outline-primary w-100 fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#advancedGeneralSettings" aria-expanded="false" aria-controls="advancedGeneralSettings" style="border-radius: 12px; font-size: 0.95rem; border-style: dashed; border-width: 2px;">
                                            <i class="bx bx-slider me-1"></i> Address, Working Hours, Google Maps, & Socials
                                        </button>
                                    </div>

                                    <!-- Collapsible Body Content -->
                                    <div class="collapse" id="advancedGeneralSettings">
                                        <div class="card card-body p-4 bg-light border mt-3 mb-3" style="border-radius: 12px; border-style: dashed !important; border-width: 1px !important;">
                                            <div class="row">
                                                <!-- Address and Footer Area -->
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold text-primary mb-3"><i class="bx bx-map-pin me-1"></i> Address & Operating Hours</h6>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="address">Studio Location / Address</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="bx bx-map"></i></span>
                                                            <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $settings?->address) }}" placeholder="e.g. Kinari Bazar, Agra, Uttar Pradesh, India">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="working_hours">Business Operating Hours</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="bx bx-time"></i></span>
                                                            <input type="text" class="form-control" name="working_hours" id="working_hours" value="{{ old('working_hours', $settings?->working_hours) }}" placeholder="e.g. Monday - Saturday (10:00 AM - 8:00 PM)">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="map_embed_url">Google Maps Embed URL / Iframe src</label>
                                                        <textarea class="form-control" name="map_embed_url" id="map_embed_url" rows="2" placeholder="https://www.google.com/maps/embed?pb=...">{{ old('map_embed_url', $settings?->map_embed_url) }}</textarea>
                                                        <span class="text-muted small">Paste Google Maps embed link to show interactive map on Contact Us page.</span>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="footer_desc">Footer Description</label>
                                                        <textarea class="form-control" name="footer_desc" id="footer_desc" rows="2" placeholder="Write a description for your footer...">{{ old('footer_desc', $settings?->footer_desc) }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="copyright_text">Footer Copyright Holder</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="bx bx-copyright"></i></span>
                                                            <input type="text" class="form-control" name="copyright_text" id="copyright_text" value="{{ old('copyright_text', $settings?->copyright_text) }}" placeholder="e.g. Amar Nath Hampers & Materials">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Social Media Links -->
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold text-success mb-3"><i class="bx bx-share-alt me-1"></i> Social Media Links</h6>
                                                    <p class="text-muted small mb-4">Provide valid URL paths. Unfilled social profiles will be dynamically hidden from the homepage.</p>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="facebook">Facebook Link</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text text-primary"><i class="bx bxl-facebook-circle"></i></span>
                                                            <input type="url" class="form-control" name="facebook" id="facebook" value="{{ old('facebook', $settings?->facebook) }}" placeholder="https://facebook.com/username">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="twitter">X / Twitter Link</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text text-dark"><i class="bx bxl-twitter"></i></span>
                                                            <input type="url" class="form-control" name="twitter" id="twitter" value="{{ old('twitter', $settings?->twitter) }}" placeholder="https://x.com/username">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="instagram">Instagram Link</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text" style="color: #e1306c;"><i class="bx bxl-instagram-alt"></i></span>
                                                            <input type="url" class="form-control" name="instagram" id="instagram" value="{{ old('instagram', $settings?->instagram) }}" placeholder="https://instagram.com/username">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="linkedin">LinkedIn Link</label>
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text text-info"><i class="bx bxl-linkedin-square"></i></span>
                                                            <input type="url" class="form-control" name="linkedin" id="linkedin" value="{{ old('linkedin', $settings?->linkedin) }}" placeholder="https://linkedin.com/in/username">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Action Bar -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-4 mb-6" style="border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); background: white;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted small">Ensure files satisfy max upload requirements before saving</span>
                                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold" style="border-radius: 8px;">
                                        <i class="bx bx-save me-1"></i> Save Site Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tab 2: Sliders List -->
            <div class="tab-pane fade {{ request('tab') === 'sliders' ? 'show active' : '' }}" id="navs-justified-sliders" role="tabpanel">
                <div class="card mt-4" style="border-radius: 16px; box-shadow: 0 8px 26px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.05);">
                    <div class="card-header d-flex justify-content-between align-items-center border-bottom py-4">
                        <div>
                            <h5 class="mb-0 text-dark" style="font-weight: 700;">Hero Banner Sliders</h5>
                            <span class="text-muted small">Dynamic banners rendered in Owl Carousel on the frontend</span>
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSliderModal" style="border-radius: 8px; font-weight: 600;">
                            <i class="bx bx-plus me-1"></i> Add Banner Slide
                        </button>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th style="padding: 16px 24px; font-weight: 700; width: 80px;">Order</th>
                                    <th style="padding: 16px 24px; font-weight: 700; width: 140px;">Slide Preview</th>
                                    <th style="padding: 16px 24px; font-weight: 700;">Slide Details</th>
                                    <th style="padding: 16px 24px; font-weight: 700; width: 220px;">Button Links</th>
                                    <th style="padding: 16px 24px; font-weight: 700; width: 120px; text-align: center;">Status</th>
                                    <th style="padding: 16px 24px; font-weight: 700; width: 150px; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sliders as $slider)
                                    <tr>
                                        <td style="padding: 20px 24px;">
                                            <strong class="text-secondary" style="font-size: 1.1rem;">#{{ $slider->orders }}</strong>
                                        </td>
                                        <td style="padding: 20px 24px;">
                                            <div class="slider-thumbnail" style="width: 100px; height: 60px; border-radius: 8px; border: 1px solid #e9ecef; overflow: hidden; background-color: #f8f9fa;">
                                                <img src="{{ asset($slider->image_path) }}" alt="Slider Banner" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </td>
                                        <td style="padding: 20px 24px;">
                                            <div class="slider-info">
                                                @if($slider->subtitle)
                                                    <span class="badge bg-label-secondary px-2 mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">{{ $slider->subtitle }}</span>
                                                @endif
                                                <h6 class="mb-1 text-dark" style="font-weight: 700;">{!! strip_tags($slider->title) !!}</h6>
                                                <p class="text-muted mb-0 small" style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">{{ $slider->description }}</p>
                                            </div>
                                        </td>
                                        <td style="padding: 20px 24px;">
                                            <div class="d-flex flex-column gap-1 small text-muted">
                                                @if($slider->btn1_text)
                                                    <div><i class="bx bx-link-external text-primary"></i> <strong>{{ $slider->btn1_text }}</strong> ➡️ <code style="font-size: 0.75rem;">{{ $slider->btn1_link ?: '#' }}</code></div>
                                                @endif
                                                @if($slider->btn2_text)
                                                    <div><i class="bx bx-link-external text-success"></i> <strong>{{ $slider->btn2_text }}</strong> ➡️ <code style="font-size: 0.75rem;">{{ $slider->btn2_link ?: '#' }}</code></div>
                                                @endif
                                                @if(!$slider->btn1_text && !$slider->btn2_text)
                                                    <span class="text-muted small italic">No Buttons Configured</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td style="padding: 20px 24px; text-align: center;">
                                            @if((int) $slider->status === 1)
                                                <span class="badge-premium-active">Active</span>
                                            @else
                                                <span class="badge-premium-inactive">Inactive</span>
                                            @endif
                                        </td>
                                        <td style="padding: 20px 24px; text-align: center;">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <a href="{{ route('homepage.editSlider', $slider) }}" class="btn btn-sm btn-outline-primary" style="padding: 6px 12px; border-radius: 6px;">
                                                    <i class="bx bx-edit-alt"></i> Edit
                                                </a>
                                                <form action="{{ route('homepage.destroySlider', $slider) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner slide?');" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 6px 12px; border-radius: 6px;">
                                                        <i class="bx bx-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-6 text-muted">
                                            <div class="py-4">
                                                <i class="bx bx-images text-light" style="font-size: 4rem;"></i>
                                                <h6 class="mt-3" style="font-weight: 600;">No Dynamic Slides Registered</h6>
                                                <p class="text-muted small">The homepage is currently running with standard fallback template sliders.</p>
                                                <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addSliderModal">
                                                    <i class="bx bx-plus me-1"></i> Create First Dynamic Slide
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ================= ADD SLIDER MODAL ================= -->
<div class="modal fade" id="addSliderModal" tabindex="-1" aria-hidden="true" style="backdrop-filter: blur(5px);">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header border-bottom py-4" style="background: #f8f9fa; border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <div>
                    <h5 class="modal-title text-dark fw-bold" id="addSliderModalLabel"><i class="bx bx-image-add text-primary me-1" style="font-size: 1.3rem;"></i> Add Banner Slide</h5>
                    <span class="text-muted small">Create a new hero section slide for the homepage carousel</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('homepage.storeSlider') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-5 px-6">
                    <div class="row">
                        <!-- Slide Banner Image Upload -->
                        <div class="col-md-6 border-end">
                            <label class="form-label fw-bold text-secondary mb-2">Background Graphic (Required)</label>
                            <div class="p-4 rounded text-center mb-3 d-flex flex-column align-items-center justify-content-center" style="background-color: #f8f9fa; border: 2px dashed #d9dee3; height: 260px; transition: border-color 0.25s;">
                                <div class="image-preview-container-modal w-100 h-100 d-flex flex-column align-items-center justify-content-center" id="modal-image-preview">
                                    <i class="bx bx-cloud-upload text-light mb-2" style="font-size: 4rem;"></i>
                                    <span class="text-secondary small fw-bold">Drag & Drop or Click to Upload</span>
                                    <span class="text-muted small d-block mt-1">Accepts JPEG, PNG, JPG, WEBP</span>
                                </div>
                                <input class="form-control position-absolute opacity-0" type="file" name="image" id="modal_image" accept="image/*" required onchange="previewModalFile()" style="height: 230px; width: 330px; cursor: pointer; z-index: 10;">
                            </div>
                            <span class="text-muted small text-center d-block">Automatic resizing will adapt any resolution flawlessly.</span>
                        </div>

                        <!-- Essential Slide Title -->
                        <div class="col-md-6 d-flex flex-column justify-content-center">
                            <div class="mb-4">
                                <label class="form-label fw-bold" for="modal_title">Slide Title (Required)</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-heading"></i></span>
                                    <input type="text" class="form-control py-2" id="modal_title" name="title" placeholder="e.g. Premium Gift Hampers" required>
                                </div>
                                <span class="text-muted small d-block mt-1">Main banner text. Use <code>&lt;br&gt;</code> to force line breaks.</span>
                            </div>

                            <!-- Advanced collapsed drawer toggle button -->
                            <div class="mt-2">
                                <button class="btn btn-outline-secondary btn-sm w-100 fw-bold py-2" type="button" data-bs-toggle="collapse" data-bs-target="#advancedSliderOptions" aria-expanded="false" aria-controls="advancedSliderOptions" style="border-radius: 8px;">
                                    <i class="bx bx-slider-alt me-1"></i> Advanced Details & Buttons (Optional)
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Collapsible Advanced Sliders Section -->
                    <div class="collapse mt-4" id="advancedSliderOptions">
                        <div class="card card-body p-4 bg-light border" style="border-radius: 12px; border-style: dashed !important; border-width: 1px !important;">
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold" for="m_subtitle">Subtitle / Category Badge</label>
                                    <input type="text" class="form-control form-control-sm" id="m_subtitle" name="subtitle" placeholder="e.g. Start from $25.00">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold" for="m_orders">Display Sort Order</label>
                                    <input type="number" class="form-control form-control-sm" id="m_orders" name="orders" value="0">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold" for="m_status">Status</label>
                                    <select class="form-select form-select-sm" id="m_status" name="status">
                                        <option value="1" selected>Active (Visible)</option>
                                        <option value="2">Inactive (Draft)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold" for="m_description">Description / Paragraph Text</label>
                                <textarea class="form-control form-control-sm" id="m_description" name="description" rows="2" placeholder="Brief description to capture interest..."></textarea>
                            </div>

                            <div class="row">
                                <!-- Button 1 -->
                                <div class="col-md-6 border-end">
                                    <h6 class="text-primary fw-bold mb-2 small"><i class="bx bx-link me-1"></i> Button 1 (Primary Action)</h6>
                                    <div class="mb-2">
                                        <input type="text" class="form-control form-control-sm" name="btn1_text" placeholder="Button Text (e.g. Shop Now)">
                                    </div>
                                    <div>
                                        <input type="text" class="form-control form-control-sm" name="btn1_link" placeholder="Button Link (e.g. /shop)">
                                    </div>
                                </div>
                                <!-- Button 2 -->
                                <div class="col-md-6">
                                    <h6 class="text-success fw-bold mb-2 small"><i class="bx bx-link me-1"></i> Button 2 (Secondary Action)</h6>
                                    <div class="mb-2">
                                        <input type="text" class="form-control form-control-sm" name="btn2_text" placeholder="Button Text (e.g. Learn More)">
                                    </div>
                                    <div>
                                        <input type="text" class="form-control form-control-sm" name="btn2_link" placeholder="Button Link (e.g. /about)">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top py-3 px-6" style="background: #f8f9fa; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-bold" style="border-radius: 8px;"><i class="bx bx-check-circle me-1"></i> Save Banner Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewModalFile() {
    const preview = document.getElementById('modal-image-preview');
    const file = document.getElementById('modal_image').files[0];
    const reader = new FileReader();

    reader.addEventListener("load", function () {
        preview.innerHTML = `<img src="${reader.result}" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px;">`;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
