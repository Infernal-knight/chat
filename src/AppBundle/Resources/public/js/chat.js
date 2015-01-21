
jQuery.fn.scrollTo = function(elem) {
    $(this).scrollTop($(this).scrollTop() - $(this).offset().top + $(elem).offset().top);
    return this;
};

$(function() {
    if (Clank instanceof Object) {

        var chat = Clank.connect(chat_url);

        chat.on('socket/connect', function(session){
            chat.session = session;
            session.subscribe('chat', function(uri, payload){
                //console.log('Received:', payload);

                switch (payload.action) {
                    case 'messagePrivate':
                    case 'messageNew':
                        $message = $(payload.params.message);
                        $chat = $('#chat');
                        $chat.append($message);
                        $chat.scrollTo($message);
                        break;

                    case 'userList':
                        $('#users').html(payload.params.userList);
                        break;

                    case 'userAdd':
                        $('#users').append(payload.params.user);
                        break;

                    case 'userRemove':
                        $($("[data-uid='" + payload.params.userId + "']")[0]).remove();
                        break;

                    default:
                        break;
                }
            });

            session.publish('chat', {action: 'userList'});
        });

        chat.on("socket/disconnect", function(error){
            alert('Disconnected!');
            location = location;
            //console.log("Disconnected for " + error.reason + " with code " + error.code);
        });

        var sendFunction = function () {
            $input = $('#input');
            $privateTo = $('#privateTo');
            if ($input.val()) {
                if ($privateTo.data('uid')) {
                    chat.session.publish('chat', {action: 'messagePrivate', params: { message: $input.val(), receiver: $privateTo.data('uid') } });
                    $privateTo.text('');
                    $privateTo.data('uid', '');
                    $('#private').hide();
                } else {
                    chat.session.publish('chat', {action: 'messageNew', params: { message: $input.val() } });
                }
                $input.val('');
                $input.focus();
            }
        }

        $('#submit').click(sendFunction);
        $('#input').keypress(function(event) {
            if (event.which == 13 && event.shiftKey == false) {
                event.preventDefault();
                sendFunction();
            }
        });

        $('#users').on('click', '.uid', function () {
            $this = $(this);
            $('#private').show();
            $privateTo = $('#privateTo');
            $privateTo.text($this.text());
            $privateTo.data('uid', $this.data('uid'));
        });

        $('#privateCancel').click(function () {
            $privateTo = $('#privateTo');
            $privateTo.text('');
            $privateTo.data('uid', '');
            $('#private').hide();
        });

        $('#chat').scrollTo($('#chat .row:last-child'));
    }
});
