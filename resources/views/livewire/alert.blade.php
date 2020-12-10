<script type="module">
    function notification(event){
        new Noty({
            theme: 'sunset',
            type: event.detail['type'],
            layout: 'topRight',
            text: event.detail['text'],
            timeout: 3000,
        }).show();
    }

    window.addEventListener('notify', notification);
</script>
