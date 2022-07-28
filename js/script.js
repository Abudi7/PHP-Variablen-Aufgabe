/**
 * Send links of class "delete" via post after a confermation dialog
 */

$("a.delete").on("click",function(e){

    e.preventDefault();
    //function confirm to show a messag with choose yes or cansel
    if (confirm("Are you sure?")) {
        //function alert to display a message 
        //alert("delete the article");
        //to creat form i put $ with praket und cotion "" 
        var frm = $("<form>");
        //First, we'll set the method to be post using the attribute function. Then we need to set the action attribute
        frm.attr('method','post');
        frm.attr('action', $(this).attr('href'));
        frm.appendTo("body");
        frm.submit();
    }
});

// I call the jQuery validate from Vanilla Framework js 

$.validator.addMethod("dateTime",function(value,element){
    //this method return a null when the validation empty is 
    return (value == "") || ! isNaN(date.parse(value));
},"Must be a valid date and time");

/**
 * Handle the publish button for publishong articles
 */

$("#articleForm").validate({
    rules: {

        title: {
            required: true
        },
        content: {
            required: true
        },
        published_at: {
            required: true

        }
    
    }
});

/**
 * Show the date and time picker for the published_at field
 */

$("button.publish").on("click",function(e) {

    var id = $(this).data("id");
    var button = $(this);
    alert(id);
    $.ajax({
        url: '/Udemy-CMS/admin/publish.php' ,
        type: 'POST',
        data: {id: id}
    }).done(function (data) {
        button.parent().html(data);

    });  

});

/**
 * all code using jquery library
 */
$("#formContact").validate({
    rules: {
        email: {
            required: true,
            email: true
        },
        subject: {
            required: true
        },
        message: {
            required: true
        }
    }

});
