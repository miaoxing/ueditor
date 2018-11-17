<script>
  window.require && require.config({
    paths: {
      ueditor: 'plugins/ueditor/libs/neditor/i18n/zh-cn/zh-cn',
      'ueditor-all': 'plugins/ueditor/libs/neditor/neditor.all.min',
      'ueditor-config': 'plugins/ueditor/js/neditor.config',
    },
    shim: {
      ueditor: {
        deps: ['ueditor-all']
      },
      'ueditor-all': {
        deps: ['ueditor-config']
      }
    }
  });
</script>
