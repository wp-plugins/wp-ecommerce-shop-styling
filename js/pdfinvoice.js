jQuery("#download-invoice").click(function(){
    jQuery('<div id="pdf-invoice-hidden">')
        .appendTo(this)
        .hide()
        .load(jQuery(this).attr("href")+ " #invoice-link",function(){
            window.location.href=jQuery(this).find("#invoice-link").attr("href");
        })
        .remove();
    return false;
});