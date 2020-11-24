import React from 'react';

class FormItemUeditor extends React.Component {
  editor;

  componentDidUpdate(prevProps) {
    if (!this.editor) {
      return;
    }

    // Only set data for the first time
    if (typeof prevProps.value === 'undefined' && typeof this.props.value !== 'undefined') {
      this.editor.ready(() => {
        this.editor.setContent(this.props.value);
      });
    }
  }

  componentDidMount() {
    this.load();
    window.UE_LOADING_PROMISE.then(() => {
      this.editor = UE.getEditor(this.props.id);
      this.editor.addListener('contentChange', () => {
        this.props.onChange(this.editor.getContent());
      });
    });
  }

  componentWillUnmount() {
    if (this.editor) {
      this.editor.destroy();
    }
  }

  /**
   * @link https://github.com/BSTester/react-neditor
   */
  load() {
    const neditorPath = '/plugins/ueditor/libs/neditor';
    if (!window.UE && !window.UE_LOADING_PROMISE) {
      window.UE_LOADING_PROMISE = this.createScript('/plugins/ueditor/js/neditor.config.js').then(() => {
        return this.props.debug
          ? this.createScript(neditorPath + '/neditor.all.js')
          : this.createScript(neditorPath + '/neditor.all.min.js')
      });
    }
  }

  createScript = url => {
    let scriptTags = window.document.querySelectorAll('script')
    let len = scriptTags.length
    let i = 0
    let _url = window.location.origin + url
    return new Promise((resolve, reject) => {
      for (i = 0; i < len; i++) {
        var src = scriptTags[i].src
        if (src && src === _url) {
          scriptTags[i].parentElement.removeChild(scriptTags[i])
        }
      }

      let node = document.createElement('script')
      node.src = url
      node.onload = resolve
      document.body.appendChild(node)
    })
  }

  render() {
    const {debug, ...rest} = this.props;
    return <textarea name={this.props.id} {...rest}/>;
  }
}

export default FormItemUeditor;
