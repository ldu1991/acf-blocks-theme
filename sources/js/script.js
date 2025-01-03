import Swiper from 'swiper/bundle';
import "@fancyapps/fancybox"


(function ($) {
    /*testimonials slider*/
    const testimonialsSwiper = new Swiper('.testimonials-swiper', {
        slidesPerView: 1,
        spaceBetween:  24,
        speed:         600,
        pagination:    {
            el:        '.swiper-pagination',
            type:      'bullets',
            clickable: true,
        },
        navigation:    {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        breakpoints: {
            700: {
                slidesPerView: 2,
                spaceBetween:  24
            },
            992: {
                slidesPerView: 3,
                spaceBetween:  32,
            }
        }
    });

    /*testimonials slider*/
    const studiesSwiper = new Swiper('.studies-swiper', {
        slidesPerView: 1,
        spaceBetween:  24,
        speed:         600,
        pagination:    {
            el:        '.swiper-pagination',
            type:      'bullets',
            clickable: true,
        },
        navigation:    {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        breakpoints: {
            700:  {
                slidesPerView: 2,
                spaceBetween:  24
            },
            992:  {
                slidesPerView: 3,
                spaceBetween:  32,
            },
            1400: {
                slidesPerView: 3,
                spaceBetween:  48,
            }
        }
    });


    /*testimonials slider*/
    const guideSwiper = new Swiper('.guide-swiper', {
        slidesPerView: 1,
        spaceBetween:  24,
        speed:         600,
        pagination:    {
            el:        '.swiper-pagination',
            type:      'bullets',
            clickable: true,
        },
        navigation:    {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        breakpoints: {
            700:  {
                slidesPerView: 2,
                spaceBetween:  24
            },
            992:  {
                slidesPerView: 3,
                spaceBetween:  32,
            },
            1400: {
                slidesPerView: 3,
                spaceBetween:  48,
            }
        }
    });

    /*accordion*/
    let faqAccordion = $('.dmp-faq__accordion')
    faqAccordion.accordion({
        heightStyle: "content",
        header:      ".dmp-faq__accordion-item > .dmp-faq__accordion-item-head",
        collapsible: true,
        icons:       false,
        active:      false,
        activate:    function (event, ui) {
            jQuery('.ui-accordion-header').attr('tabindex', '0');
        }
    });

    faqAccordion.find('.ui-accordion-content').removeAttr('aria-labelledby role aria-hidden')

    let $select = $('select')
    if ($select.length) {
        $select.select2({
            minimumResultsForSearch: -1,
            width:                   false,
            placeholder:             $select.find('.gf_placeholder').length ? $select.find('.gf_placeholder').text() : ''
        })
    }
    /*$(document).on('gform_validation_failed', function(event, formId) {
        console.log(formId)

        if($select.length) {
            $select.select2({
                minimumResultsForSearch: -1,
                width:                   false,
                placeholder: $select.find('.gf_placeholder').length ? $select.find('.gf_placeholder').text() : ''
            })
        }
    })*/

    let ginput_container_fileupload = document.querySelector('.ginput_container_fileupload')
    if (!!ginput_container_fileupload) {
        let fileInput = ginput_container_fileupload.querySelector('[type="file"]')
        fileInput.addEventListener('change', function () {
            if (fileInput.files.length > 0) {
                ginput_container_fileupload.style.setProperty('--dmp-text', `'${fileInput.files[0].name}'`);
            } else {
                ginput_container_fileupload.style.setProperty('--dmp-text', 'No file chosen');
            }
        });
    }

    /*sort*/
    $('.dmp-btn_sort').on('click', function () {
        if (!($(this).hasClass('active'))) {
            $('.dmp-btn_sort.active').removeClass('active');
            $(this).addClass('active');
        }
    });


    /*header*/

    $('.dmp-header__burger').on('click', function () {
        if (!($(this).hasClass('active'))) {
            $('.dmp-header').addClass('show');
            $('body').addClass('dmp-modal-open');
            $(this).addClass('active');
        } else {
            $('.dmp-header').removeClass('show');
            $('body').removeClass('dmp-modal-open');
            $(this).removeClass('active');
        }
    })

})(jQuery);

let copyButton = document.querySelector('.dmp-copy-button')
if (!!copyButton) {
    copyButton.addEventListener('click', function () {
        navigator.clipboard.writeText(copyButton.value)
            .then(() => {
                alert('Link copied to clipboard! ' + copyButton.value);
            })
            .catch((err) => {
                console.error('Copy error: ', err);
            });
    })
}

// ------------ Deleting placeholder focus ------------ //
function focusFnInput(target) {
    if (target.getAttribute('placeholder') !== null) {
        target.setAttribute('data-placeholder', target.getAttribute('placeholder'))
        target.setAttribute('placeholder', '')
    }
}

document.addEventListener('focus', function (event) {
    for (let target = event.target; target && target !== this; target = target.parentNode) {
        if (target.matches('input, textarea')) {
            focusFnInput.call(this, target, event)
            break;
        }
    }
}, true);

function blurFnInput(target) {
    if (target.getAttribute('data-placeholder') !== null) {
        target.setAttribute('placeholder', target.getAttribute('data-placeholder'))
    }
}

document.addEventListener('blur', function (event) {
    for (let target = event.target; target && target !== this; target = target.parentNode) {
        if (target.matches('input, textarea')) {
            blurFnInput.call(this, target, event)
            break;
        }
    }
}, true);
// ---------- End Deleting placeholder focus ---------- //
