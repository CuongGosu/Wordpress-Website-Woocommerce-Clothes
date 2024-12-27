var loader = `<div class=\"gm-loader\" style="position:fixed;z-index:99999999;top:0;left:0;right:0;bottom:0;display:flex;align-items:center;justify-content:center;background-color:rgba(0,0,0,0.51)"><div class=\"windows8\"> <div class=\"wBall\" id=\"wBall_1\"> <div class=\"wInnerBall\"> </div> </div> <div class=\"wBall\" id=\"wBall_2\"> <div class=\"wInnerBall\"> </div> </div> <div class=\"wBall\" id=\"wBall_3\"> <div class=\"wInnerBall\"> </div> </div> <div class=\"wBall\" id=\"wBall_4\"> <div class=\"wInnerBall\"> </div> </div> <div class=\"wBall\" id=\"wBall_5\"> <div class=\"wInnerBall\"> </div> </div> </div></div>`;
$('#contact_form').submit(function (e) {
  e.preventDefault();
  let form = $(this);
  form.validate();
  if (form.valid()) {
    $('body').append(loader);
    $.post(
      $(this).attr('action'),
      {
        action: 'send_contact_form',
        _token: $(this).find('[name="_token"]').val(),
        name: $(this).find('[name="name"]').val(),
        email: $(this).find('[name="email"]').val(),
        phone_number: $(this).find('[name="phone_number"]').val(),
        subject: $(this).find('[name="subject"]').val(),
        message: $(this).find('[name="message"]').val(),
      },
      function (response) {
        if (response.success === true) {
          var contact_danger = document.getElementById('contact_danger').value;
          var contact_success =
            document.getElementById('contact_success').value;
          swal(contact_danger, contact_success, 'success');
          form.trigger('reset');
        } else {
          var contact_waring = document.getElementById('contact_waring').value;
          var contact_error = document.getElementById('contact_error').value;
          swal(contact_waring, contact_error, 'error');
        }
        $(document).find('.gm-loader').remove();
      }
    );
  }
});

$('.contact-form').submit(function (e) {
  e.preventDefault();
  let form = $(this);
  form.validate();
  if (form.valid()) {
    $('body').append(loader);
    $.post(
      $(this).attr('action'),
      {
        action: 'send_register_form',
        _token: $(this).find('[name="_token"]').val(),
        register_email: $(this).find('[name="register_email"]').val(),
      },
      function (response) {
        if (response.success === true) {
          swal(
            'Success',
            'You have successfully registered to receive news !',
            'success'
          );
          form.trigger('reset');
        } else {
          swal('Error', 'There was an error during registration', 'error');
        }
        $(document).find('.gm-loader').remove();
      }
    );
  }
});

$('#homepage_slider').owlCarousel({
  items: 1,
  loop: true,
  margin: 0,
  autoplay: true,
  autoplayHoverPause: true,
  dots: true,
  nav: false,
});

$('.list-slider-banner').owlCarousel({
  items: 3,
  loop: true,
  margin: 0,
  autoplay: true,
  autoplayHoverPause: true,
  dots: true,
  nav: false,
  responsive: {
    0: {
      items: 1,
    },
    768: {
      items: 2,
    },
    991: {
      items: 3,
    },
  },
});

$(window).scroll(function () {
  // Lặp qua các phần tử có class 'my-div'
  $('.animation-tran').each(function () {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();
    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    // Kiểm tra xem phần tử có trên màn hình hay không
    if (elementBottom > viewportTop && elementTop < viewportBottom) {
      $(this).addClass('active');
    } else {
      $(this).removeClass('active');
    }
  });
});

$('.footer-title').click(function () {
  if ($(window).width() < 768) {
    $(this).next('.footer-content').toggle(500);
  }
});
$('.page_menu_title.title_block, .sidebarblog-title.title_block').click(
  function () {
    if ($(window).width() < 768) {
      $(this).next('.layered.layered-category').toggle(500);
    }
  }
);

$('.header-action_search .box-icon').click(function () {
  $('.header-action_search').toggleClass('show-action');
  $('.header-action_cart.show-action').removeClass('show-action');
});
$('.header-action_menu').click(function () {
  $(this).toggleClass('show-action');
  $('body').toggleClass('none-scroll');
});
$('.header-action_cart').click(function () {
  $(this).toggleClass('show-action');
  $('.header-action_search.show-action').removeClass('show-action');
  $('#site-header')
    .removeClass('hSticky')
    .removeClass('hSticky-nav')
    .removeClass('hSticky-up');
});

// document.addEventListener('DOMContentLoaded', function () {
//   jQuery(document.body).on(
//     'added_to_cart',
//     function (event, fragments, cart_hash, $button) {
//       $('.header-action_cart').addClass('show-action');
//       if (window.innerWidth <= 991) {
//         $('#site-header').addClass('hSticky-up');
//       } else {
//         $('#site-header')
//           .addClass('hSticky')
//           .addClass('hSticky-nav')
//           .addClass('hSticky-up');
//       }
//     }
//   );
// });

const thumbPlaceholders = document.querySelectorAll(
  '.product-gallery__thumb-placeholder'
);
const galleryItems = document.querySelectorAll('.product-gallery-item');

thumbPlaceholders.forEach((thumb, index) => {
  thumb.addEventListener('click', () => {
    document
      .querySelector('.product-gallery__thumb.active')
      ?.classList.remove('active');
    thumb.closest('.product-gallery__thumb')?.classList.add('active');

    const dataImage = thumb.getAttribute('data-image');

    galleryItems.forEach((item) => {
      const img = item.querySelector('img');
      item.classList.toggle('current', img.getAttribute('src') === dataImage);
    });

    const currentGalleryItem = document.querySelector(
      '.product-gallery-item.current'
    );
    if (currentGalleryItem) {
      currentGalleryItem.scrollIntoView({
        behavior: 'smooth',
        block: 'nearest',
      });
    }
  });
});

$('.swatch-element.size').click(function () {
  $('.swatch-element.size label').removeClass('sd');
  $(this).find('label').addClass('sd');
  var size = $(this).data('value');
  var color = $('.swatch-element.color label.sd')
    .parent('.color')
    .data('value');
  type_pro = size + '-' + color;
  var info_pro = $('#info_pro').data('info');
  console.log(info_pro);
  if (info_pro[0].price != '') {
    var sku = null;
    var price = null;
    var cart = null;

    for (var i = 0; i < info_pro.length; i++) {
      if (info_pro[i].size_color === type_pro) {
        sku = info_pro[i].sku;
        price = info_pro[i].price;
        cart = info_pro[i].cart;
        break;
      }
    }

    if (price !== null) {
      // $('#pro_sku').html('<strong>SKU:</strong> ' + sku);
      $('#price-preview').html(price);
    }
    $('.cart-variable').each(function () {
      var dataCart = $(this).data('cart');
      console.log(dataCart, cart);
      if (dataCart === cart) {
        $(this).removeClass('d-none').addClass('d-block');
      } else {
        $(this).removeClass('d-block').addClass('d-none');
      }
    });
  }
});

$('.swatch-element.color').click(function () {
  $('.swatch-element.color label').removeClass('sd');
  $(this).find('label').addClass('sd');
  var color = $(this).data('value');
  var size = $('.swatch-element.size label.sd').parent('.size').data('value');
  type_pro = size + '-' + color;
  var info_pro = $('#info_pro').data('info');
  if (info_pro[0].price != '') {
    var sku = null;
    var price = null;
    var cart = null;

    for (var i = 0; i < info_pro.length; i++) {
      if (info_pro[i].size_color === type_pro) {
        sku = info_pro[i].sku;
        price = info_pro[i].price;
        cart = info_pro[i].cart;
        break;
      }
    }

    if (price !== null) {
      // $('#pro_sku').html('<strong>SKU:</strong> ' + sku);
      $('#price-preview').html(price);
    }

    $('.cart-variable').each(function () {
      var dataCart = $(this).data('cart');
      if (dataCart === cart) {
        $(this).removeClass('d-none').addClass('d-block');
      } else {
        $(this).removeClass('d-block').addClass('d-none');
      }
    });
  }
});

if (window.innerWidth <= 991) {
  const siteHeader = document.getElementById('site-header');

  if (siteHeader) {
    let isStickyUp = false;
    let prevScrollTop = 0;

    window.addEventListener('scroll', function () {
      const scrollTop = window.scrollY;

      // Bước 3: Nếu người dùng cuộn nhích lên một chút, thêm class "hSticky-up"
      if (scrollTop > siteHeader.offsetTop && scrollTop < prevScrollTop) {
        siteHeader.classList.add('hSticky-up');
      } else {
        siteHeader.classList.remove('hSticky-up');
      }

      // Bước 4: Cập nhật trạng thái cuộn lên và lưu vị trí cuộn trước đó
      isStickyUp = scrollTop < siteHeader.offsetTop;
      prevScrollTop = scrollTop;

      if (scrollTop >= siteHeader.offsetTop) {
        siteHeader.classList.add('hSticky', 'hSticky-nav');
      } else {
        siteHeader.classList.remove('hSticky', 'hSticky-nav');
      }

      // Bước 5: Nếu người dùng cuộn lên trên cùng, loại bỏ class "hSticky" và "hSticky-nav"
      if (scrollTop === 0) {
        siteHeader.classList.remove('hSticky', 'hSticky-nav');
      }
    });
  }
}
//
// Get number item for cart header
// Kiểm tra xem giá trị cập nhật có chính xác không
$(document).on('woocommerce_cart_item_removed', function (event, cart_hash) {
  // Cập nhật số lượng sản phẩm trên header
  $.ajax({
    type: 'POST',
    url: '/cart.js',
    data: {
      action: 'update_cart_count',
    },
    success: function (response) {
      // Cập nhật số lượng sản phẩm trên header
      $('.header-cart .count').html(response.item_count);
    },
  });
});
// Khởi tạo mmenu
const menu = new Mmenu('#header-list-navigation__mobile', {
  extensions: ['fullscreen', 'pagedim-black'], // Mở fullscreen và có bóng mờ nền
  navbars: [
    {
      position: 'top',
      content: ['close'],
    },
  ],
  offCanvas: {
    position: 'left', // Hoặc "right" tùy vào vị trí mong muốn
  },
});
