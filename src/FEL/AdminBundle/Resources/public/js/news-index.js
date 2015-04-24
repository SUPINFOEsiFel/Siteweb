/**
 * Created by jitrixis on 22/04/15.
 */
$('.records_list tr[data-href]').click(function (e) {
    document.location.href = $(e.currentTarget).data("href");
})