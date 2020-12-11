<script type="module">
    function notification(event){
        new Noty({
            theme: event.detail['theme'],
            type: event.detail['type'],
            layout: event.detail['layout'],
            text: event.detail['text'],
            timeout: event.detail['timeout'],
        }).show();
    }

    window.addEventListener('notify', notification);
</script>
