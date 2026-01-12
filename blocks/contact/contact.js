(function ($) {
    class ContactFormRcV3 {
        constructor(form) {
            console.log('[Contact Form Debug] Initializing form:', form);

            try {
                this.form = document.querySelector(form);
                this.submit = this.form.querySelector(".btn-submit-js");
                console.log('[Contact Form Debug] Form found:', !!this.form);
                console.log('[Contact Form Debug] Submit button found:', !!this.submit);

                this.events();
            } catch (err) {
                console.error('[Contact Form Debug] Constructor error:', err.message);
            }
        }

        events() {
            console.log('[Contact Form Debug] Setting up events');

            $(this.form).find(".field-js").on("keyup", () => {
                var filled = false;

                $(this.form).find(".field-js").each(
                    function () {
                        if ($(this).val().length > 0) {
                            filled = true;
                        }
                    }
                );

                if (filled) {
                    $(".fade-in-js").fadeIn();
                } else {
                    $(".fade-in-js").fadeOut();
                }

            });

            this.submit.addEventListener("click", (e) => {
                e.preventDefault();
                console.log('[Contact Form Debug] ========== FORM SUBMIT START ==========');

                const form = $(this.form);
                const formElement = this.form;

                console.log('[Contact Form Debug] Checking grecaptcha...');
                console.log('[Contact Form Debug] typeof grecaptcha:', typeof grecaptcha);
                
                if (typeof grecaptcha === 'undefined') {
                    console.error('[Contact Form Debug] ❌ grecaptcha is UNDEFINED!');
                    form.parent().find('.form__error').html("reCAPTCHA not loaded. Please refresh the page.").addClass("active");
                    return;
                }
                console.log('[Contact Form Debug] ✅ grecaptcha available');
                console.log('[Contact Form Debug] Site key:', contact.rcSiteKey);

                grecaptcha.ready(() => {
                    console.log('[Contact Form Debug] ✅ grecaptcha.ready() fired');
                    console.log('[Contact Form Debug] Form validity:', formElement.checkValidity());
                    
                    if (formElement.checkValidity()) {
                        console.log('[Contact Form Debug] Executing grecaptcha.execute()...');

                        grecaptcha.execute(contact.rcSiteKey, {
                            action: 'submit'
                        }).then(function (token) {
                            console.log('[Contact Form Debug] ✅ Token received:', token ? token.substring(0, 50) + '...' : 'EMPTY');

                            if (!token) {
                                console.error('[Contact Form Debug] ❌ Token is empty!');
                                form.parent().find('.form__error').html("reCAPTCHA token empty. Please refresh.").addClass("active");
                                return;
                            }

                            const action = form.attr("send");
                            const title = form.attr("title");

                            console.log('[Contact Form Debug] AJAX Request:');
                            console.log('[Contact Form Debug] - URL:', ajaxUrl);
                            console.log('[Contact Form Debug] - Action:', action);
                            console.log('[Contact Form Debug] - Title:', title);
                            console.log('[Contact Form Debug] Sending AJAX...');

                            $.ajax({
                                type: 'POST',
                                url: ajaxUrl,
                                dataType: 'html',
                                data: form.serialize() + '&action=' + action + '&title=' + title + '&g-recaptcha-response=' + token,
                                success: function (resp) {
                                    console.log('[Contact Form Debug] ✅ AJAX Response:', resp);

                                    if (resp === 'ok') {
                                        console.log('[Contact Form Debug] ✅ SUCCESS!');

                                        form.parent().find('.form__error').removeClass("active");

                                        form.find(".field-js").each(
                                            function () {
                                                $(this).val("");
                                            }
                                        );

                                        form.find(".service-check-js").prop("checked", false);
                                        form.find(".privacy-policy-js").prop("checked", false);

                                        if (contact.redirect_on_submit) {
                                            console.log('[Contact Form Debug] Redirecting to:', contact.redirect_on_submit);
                                            window.location.href = contact.redirect_on_submit;
                                        } else {
                                            form.find(".form__thanks").addClass("active");
                                            setTimeout(() => {
                                                form.find(".form__thanks").removeClass("active");
                                            }, 5000);
                                        }

                                    } else {
                                        console.error('[Contact Form Debug] ❌ Server error:', resp);
                                        form.parent().find('.form__error').html(resp).addClass("active");
                                        form.parent().find('.form__thanks').removeClass("active");
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error('[Contact Form Debug] ❌ AJAX FAILED!');
                                    console.error('[Contact Form Debug] Status:', status);
                                    console.error('[Contact Form Debug] Error:', error);
                                    console.error('[Contact Form Debug] Response:', xhr.responseText);
                                    console.error('[Contact Form Debug] Status Code:', xhr.status);
                                    form.parent().find('.form__error').html("There was an error trying to send your message. Please try again later.").addClass("active");
                                    form.parent().find('.form__error').addClass("active");
                                    form.parent().find('.form__thanks').removeClass("active");
                                }
                            }).always(function () {
                                console.log('[Contact Form Debug] ========== FORM SUBMIT END ==========');
                            })
                        }).catch(function(error) {
                            console.error('[Contact Form Debug] ❌ grecaptcha.execute() FAILED:', error);
                            form.parent().find('.form__error').html("reCAPTCHA error. Check domain registration.").addClass("active");
                        });
                    } else {
                        console.log('[Contact Form Debug] ❌ Form validation failed');
                        formElement.reportValidity();
                    }
                });

            });
            console.log('[Contact Form Debug] ✅ Events attached');
        }

    }
    class Map {
        constructor() {

            this.map = false;
            this.view = document.querySelector("#googleMap");
            if (!this.view) {
                return;
            }

            this.zoom = 16;

            this.markers = [];
            this.location = [];

            this.location.lat = parseFloat(contact.lat);
            this.location.lng = parseFloat(contact.lng);

        }

        addMarker() {
            var marker = new google.maps.Marker({
                position: {
                    lat: this.location.lat,
                    lng: this.location.lng
                },
                icon: {
                    url: themeUri + '/images/icons/marker.svg',
                }
            });

            marker.setMap(this.map);

            this.markers.push(marker);
        }

        removeMarkers() {
            for (let i = 0; i < this.markers.length; i++) {
                this.markers[i].setMap(null);
            }
        }

        init() {

            /*             const {
                            AdvancedMarkerElement
                        } = await google.maps.importLibrary("marker"); */

            this.map = new google.maps.Map(this.view, {
                zoom: this.zoom,
                zoomControl: true,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: false,
                styles: [{
                    "featureType": "all",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "saturation": 36
                    }, {
                        "color": "#333333"
                    }, {
                        "lightness": 40
                    }]
                }, {
                    "featureType": "all",
                    "elementType": "labels.text.stroke",
                    "stylers": [{
                        "visibility": "on"
                    }, {
                        "color": "#ffffff"
                    }, {
                        "lightness": 16
                    }]
                }, {
                    "featureType": "all",
                    "elementType": "labels.icon",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "administrative",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#fefefe"
                    }, {
                        "lightness": 20
                    }]
                }, {
                    "featureType": "administrative",
                    "elementType": "geometry.stroke",
                    "stylers": [{
                        "color": "#fefefe"
                    }, {
                        "lightness": 17
                    }, {
                        "weight": 1.2
                    }]
                }, {
                    "featureType": "landscape",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#f5f5f5"
                    }, {
                        "lightness": 20
                    }]
                }, {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#f5f5f5"
                    }, {
                        "lightness": 21
                    }]
                }, {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#c3e7b4"
                    }, {
                        "lightness": 21
                    }]
                }, {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [{
                        "color": "#ffffff"
                    }, {
                        "lightness": 17
                    }]
                }, {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [{
                        "color": "#ffffff"
                    }, {
                        "lightness": 29
                    }, {
                        "weight": 0.2
                    }]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#ffffff"
                    }, {
                        "lightness": 18
                    }]
                }, {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#ffffff"
                    }, {
                        "lightness": 16
                    }]
                }, {
                    "featureType": "transit",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#f2f2f2"
                    }, {
                        "lightness": 19
                    }]
                }, {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [{
                        "color": "#e9e9e9"
                    }, {
                        "lightness": 17
                    }]
                }]
            });

            this.map.setCenter(this.location);



            this.addMarker();


        }
    }

    window.map = new Map();

    $(document).ready(function () {
        const bf = new ContactFormRcV3("#contact-form");
    });


}(jQuery));