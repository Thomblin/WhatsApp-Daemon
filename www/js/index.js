/**
 * Created by seeb on 01.01.16.
 */

var loadMessage = function () {
    jQuery.ajax({
        url: "messages",
        method: "GET",
        cache: false,
        dataType: 'json',
        context: jQuery("#chat"),
        complete: function () {
            setTimeout(loadMessage, 1000);
        },
        success: function (data) {
            if (!data.success) {
                return;
            }

            var self = this;

            data.messages.forEach(function(message) {
                var number = message.from.split("@", 1);
                var divId = "chat_" + number;

                if (0 === jQuery("#" + divId).length) {
                    var fieldset = jQuery("<fieldset/>", {class: "customer_chat"});
                    fieldset.append(jQuery("<legend/>", {text: "+"+number+" - "+message.nickname}));
                    fieldset.append(jQuery("<div/>", {id: divId}));
                    fieldset.append(
                        jQuery("<input/>",
                            {
                                type: "text",
                                id: "text_" + number
                            }));
                    fieldset.append(jQuery("<input/>", {
                        type: "button",
                        id: "submit_" + number,
                        value: "Send",
                        "x-number": number,
                        class: "sendmsg"
                    }));

                    jQuery(self).append(fieldset);
                }

                if (!jQuery("#" + message.msg_id).length) {
                    jQuery("#" + divId).append(jQuery("<p/>",
                        {
                            id: message.msg_id,
                            text: message.body,
                            class: "msgbox received"
                        }));
                }
            });
        }
    });
};


var sendMessage = function (number, message) {
    jQuery.ajax({
        url: "messages",
        method: "POST",
        cache: false,
        dataType: 'json',
        data: {number: number, message: message},
        context: jQuery("#chat_" + number),
        success: function (data) {
            if (!data.success) {
                return;
            }

            var number = data.to;
            var divId = "chat_" + number;

            if (!jQuery("#" + data.msg_id).length) {
                jQuery("#" + divId).append(jQuery("<p/>", {
                    id: data.msg_id,
                    text: data.body,
                    class: "msgbox sent"
                }));
            }

            $("#text_" + number).val("");
        }
    });
};

loadMessage();

jQuery("#chat").on("click", ".sendmsg", function () {
    var number = $(this).attr("x-number");

    sendMessage(number, $("#text_" + number).val());
});