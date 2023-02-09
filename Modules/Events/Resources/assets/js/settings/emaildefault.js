tinymce.init({
  selector: "textarea#EVENT_EMAIL_CONTENT",
  height: "350px",
  plugins: "codesample fullscreen hr image imagetools link lists",
  toolbar:
    "styleselect | fullscreen | bold italic underline strikethrough forecolor backcolor | image link codesample hr | bullist numlist checklist",
  menubar: false,
  statusbar: false,
  file_picker_callback: function (callback, value, meta) {
    let x =
      window.innerWidth ||
      document.documentElement.clientWidth ||
      document.getElementsByTagName("body")[0].clientWidth;
    let y =
      window.innerHeight ||
      document.documentElement.clientHeight ||
      document.getElementsByTagName("body")[0].clientHeight;

    let type = "image" === meta.filetype ? "Images" : "Files",
      url = "/laravel-filemanager?editor=tinymce5&type=" + type;

    tinymce.activeEditor.windowManager.openUrl({
      url: url,
      title: "Filemanager",
      width: x * 0.8,
      height: y * 0.8,
      onMessage: (api, message) => {
        callback(message.content);
      },
    });
  },
});
