var myApp;
myApp = myApp || (function () {
    return {
        showPleaseWait: function () {
            $(".page-loader-wrapper").show();
        },
        hidePleaseWait: function () {
            $(".page-loader-wrapper").hide();
        }
    };
})();

var hideLoading = true;

function AjaxCall(url, postData, httpmethod, calldatatype, contentType, showLoading, hideLoadingParam, isAsync) {
    url = url;
    
    if (hideLoadingParam != undefined && !hideLoadingParam)
        hideLoading = hideLoadingParam;
    if (contentType == undefined)
        contentType = "application/x-www-form-urlencoded;charset=UTF-8";

    if (showLoading == undefined)
        showLoading = false;

    if (showLoading == false || showLoading.toString().toLowerCase() == "false")
        showLoading = false;
    else
        showLoading = true;

    showLoading = true;
    if (isAsync == undefined)
        isAsync = true;

    return jQuery.ajax({
        type: httpmethod,
        url: url,
        headers:
        {
            //'X-CSRF-Token': page_token
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        data: postData,
        global: showLoading,
        dataType: calldatatype,
        contentType: contentType,
        async: isAsync,
        processData:false, 
        beforeSend: function() { 
            if (showLoading) myApp.showPleaseWait();
        },
        error: function(xhr, textStatus, errorThrown) {
            if (!userAborted(xhr)) {
                if (xhr.status == 403) {
                    var response = $.parseJSON(xhr.responseText);
                    if (response != null && response.Type == "NotAuthorized" && response.Link != undefined){
                        window.location = response.Link; 
                    }
                }else if (xhr.status == 419 || xhr.status == 401) {
                    window.location.href = window.location.href;    
                }else {
                  //  alert("An error has occured");
                }
            }
        }
    });

}

function UnBlockUI() {
    myApp.hidePleaseWait();
};

$(document).ajaxStop(function (jqXHR, settings) {
    if (hideLoading) {
        UnBlockUI();
    }
});

function userAborted(xhr) {
    return !xhr.getAllResponseHeaders();
}


function ShowNotify(response) {
    $("div[data-notify='container']").remove();
    $.notifyClose();
    var timeOut = 5000, placement={from: 'top',align: 'right'}, color= '', message = 'Message';
    if(response.IsSuccess == true){
        color = 'success'
    }else{
        color = 'danger'
    }

    if(response.Message){
        message = response.Message
    }

    $.notify({
        icon: "nc-icon nc-app",
        message: message

    }, {
        type: color,
        timer: timeOut,
        placement: placement
    });
}

function ParseJsonDate(jsondate) {
    return (eval((jsondate).replace(/\/Date\((\d+)\)\//gi, "new Date($1)")));
}

function GetURLParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}

$(document).on("input", ".number_only", function() {
    this.value = this.value.replace(/\D/g,'');
});
$(document).on("input", ".text_only", function() {
    this.value = this.value.replace(/[^a-zA-Z]+/, '');
});
$(document).on("input", ".text_space_only", function() {
    this.value = this.value.replace(/[^a-zA-Z ]+/, '');
});