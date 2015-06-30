$('section').click(function(e){
    $(e.currentTarget).find(".img-loader").each(function(i, e){
        data=JSON.parse(e.innerHTML);
        html='<img src="'+data.src+'" alt="'+data.alt+'"';
        $.each(data.attr, function(i, e){html+=" "+i+"=\""+e+"\""});
        html+=' />';
        e.innerHTML=html;
        $(e).removeClass("img-loader");
    });
});
