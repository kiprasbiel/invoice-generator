<script type="module">
    function notification(event) {
        new Noty({
            theme: event.detail['theme'],
            type: event.detail['type'],
            layout: event.detail['layout'],
            text: event.detail['text'],
            timeout: event.detail['timeout'],
        }).show();
    }

    function sessionNotification(theme, type, layout, text, timeout) {
        new Noty({
            theme: theme,
            type: type,
            layout: layout,
            text: text,
            timeout: timeout,
        }).show();
    }

    window.addEventListener('notify', notification);

    @if(session()->has('message'))
        sessionNotification('{{session('message')['theme']}}', '{{session('message')['type']}}', '{{session('message')['layout']}}', '{{session('message')['text']}}', '{{session('message')['timeout']}}');
    @endif
</script>
