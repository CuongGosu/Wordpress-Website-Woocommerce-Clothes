let scripts = {
    frame           : null,
    init            : function () {
        this.frame = wp.media({
            title   : 'Chọn hình ảnh',
            button  : {
                text: 'Sử dụng hình ảnh này'
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });
        this.makeListSortable();
    },
    openMediaGallery: function () {
        if (this.frame) {
            this.frame.open();
        }
    },
    disableTheGrid  : function () {
        jQuery('form#posts-filter').append(`<div class="gm-loader" style="position:absolute;z-index:99999999;top:0;left:0;right:0;bottom:0;display:flex;align-items:center;justify-content:center;background-color:rgba(192,192,192,0.51);color:#000000">Đang cập nhật</div>`);
    },
    enableTheGrid   : function () {
        jQuery('form#posts-filter').find('.gm-loader').remove();
    },
    makeListSortable: function () {
        let tableTheList = jQuery('tbody#the-list');
        tableTheList.sortable({
            placeholder: 'ui-state-highlight',
            update     : function (event, ui) {
                scripts.disableTheGrid();
                let listItems = tableTheList.sortable('toArray');
                let postIds = [];
                for (let item of listItems) {
                    postIds.push(parseInt(item.replace('post-', '')));
                }
                let currentPage = jQuery('#current-page-selector').val();
                jQuery.post('/wp-admin/admin-ajax.php', {
                    action      : 'update_custom_sort_order',
                    post_ids    : postIds,
                    current_page: currentPage,
                }, function (response) {
                    // if (response.success === true) {}
                    scripts.enableTheGrid();
                });
            }
        });
        tableTheList.disableSelection();
    },
}

jQuery(document).on('click', '[data-trigger-toggle-feature]', function (e) {
    e.preventDefault();
    scripts.disableTheGrid();
    let thisButton = jQuery(this);
    jQuery.post('/wp-admin/admin-ajax.php', {
        action : 'toggle_is_feature',
        post_id: jQuery(this).data('post-id'),
    }, function (response) {
        if (response.success === true) {
            if (thisButton.hasClass('dashicons-yes')) {
                thisButton.removeClass('dashicons-yes').addClass('dashicons-no');
            } else {
                thisButton.removeClass('dashicons-no').addClass('dashicons-yes');
            }
        }
        scripts.enableTheGrid();
    });
});

jQuery(document).on('click', '[data-trigger-change-thumbnail-id]', function () {

    let postId = jQuery(this).data('post-id');
    let thisButton = jQuery(this);
    let frame = wp.media({
        title   : 'Chọn hình ảnh',
        button  : {
            text: 'Sử dụng hình ảnh này'
        },
        multiple: false  // Set to true to allow multiple files to be selected
    });
    frame.on('select', function () {
        let attachment = frame.state().get('selection').first().toJSON();
        console.log(attachment);
        let attachmentId = attachment.id;
        scripts.disableTheGrid();
        jQuery.post('/wp-admin/admin-ajax.php', {
            action       : 'update_post_thumbnail_id',
            post_id      : postId,
            attachment_id: attachmentId
        }, function (response) {
            if (response.success === true) {
                thisButton.find('img').attr('src', attachment.sizes.thumbnail.url);
            }
            scripts.enableTheGrid();
        });
    });
    frame.open();
});

// jQuery(function () {
//     scripts.init();
// });

jQuery(document).ready(function($) {
    function wrapPostFeaturedImage( OriginalComponent ) {
        return function ( props ) {
            var el = wp.element.createElement; // Di chuyển biến el vào trong hàm

            return el(
                wp.element.Fragment,
                {},
                el( OriginalComponent, props ),
                el('div', { dangerouslySetInnerHTML: { __html: '<p style="margin-top: 15px">'+note_feartureImage+'</p>' } })
            );
        };
    }

    if (typeof wp !== 'undefined' && typeof wp.element !== 'undefined' && typeof wp.element.createElement === 'function') {
        wp.hooks.addFilter(
            'editor.PostFeaturedImage',
            'my-plugin/wrap-post-featured-image',
            wrapPostFeaturedImage
        );
    }
});

const { registerBlockStyle } = wp.blocks;


const blockTypes = [
   'core/paragraph', 'core/heading','core/list','core/columns', 'core/column', 'core/cover', 'core/group', 'core/freeform', 'core/media-text','core/subhead', 'core/table', 'core/text-columns'
];


blockTypes.forEach((blockType) => {
    registerBlockStyle(blockType, {
        name: 'justify',
        label: 'Canh đều',
        isDefault: false,
    });
});


blockTypes.forEach((blockType) => {
    registerBlockStyle(blockType, {
        name: 'underline',
        label: 'Gạch chân',
        isDefault: false,
    });
});


blockTypes.forEach((blockType) => {
    registerBlockStyle(blockType, {
        name: 'justify-underline',
        label: 'Canh đều & Gạch chân',
        isDefault: false,
    });
});