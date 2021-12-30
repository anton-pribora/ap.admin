$(function(){

    function Uploader() {
        var $dialog = $('#fileUploadDialog');
        var errors = [];
        var activeUploads = 0;
        var visible = false;
        var onFinish = false;
        var additionalData = {};

        $dialog.on('shown.bs.modal', function(){
            visible = true;
        });

        $dialog.on('hidden.bs.modal', function(){
            visible = false;

            if (onFinish) {
                onFinish({
                    errors: errors
                });
            }
        });

        function progress(file) {
            var html = '<div>' + file.name + '</div>' +
                '<div class="progress">' +
                    '<div class="progress-bar progress-bar-striped active" style="width: 0%;">' +
                        '0%' +
                    '</div>'
                '</div>';
            var $progress = $(html);

            $dialog.find('.modal-body').append($progress);

            return {
                update: function(percent) {
                    percent += '%';
                    $progress.find('.progress-bar').css('width', percent).text(percent);
                },
                success: function() {
                    $progress.find('.progress-bar').addClass('progress-bar-success').removeClass('active');
                },
                error: function(error) {
                    $progress.find('.progress-bar').addClass('progress-bar-danger').removeClass('active').text(error);
                },
            }
        }

        function reset() {
            errors.length = 0;
            activeUploads = 0;
            visibe = false;
            var additionalData = {};
            $dialog.find('.modal-body').text('');
            $dialog.find('.modal-footer').hide();
        }

        function toFormData(obj, form, namespace) {
          var fd = form || new FormData();
          var formKey;

          for(var property in obj) {
            if (obj.hasOwnProperty(property) && obj[property] != null && obj[property] !== undefined) {
              if (namespace) {
                formKey = namespace + '[' + property + ']';
              } else {
                formKey = property;
              }

              // if the property is an object, but not a File, use recursivity.
              if (obj[property] instanceof Date) {
                fd.append(formKey, obj[property].toISOString());
              }
              else if (typeof obj[property] === 'object' && !(obj[property] instanceof File)) {
                toFormData(obj[property], fd, formKey);
              } else { // if it's a string or a File object
                fd.append(formKey, obj[property]);
              }
            }
          }

          return fd;
        }

        function sendFile(file, $progress) {
            var uri = "";
            var xhr = new XMLHttpRequest();
            var fd  = new FormData();

            ++activeUploads;

            xhr.upload.addEventListener("progress", function(e) {
                if (e.lengthComputable) {
                    var percentage = Math.round((e.loaded * 100) / e.total);
                    $progress.update(percentage);
                }
            }, false);

            xhr.upload.addEventListener("load", function(e){
                $progress.update(100);
            }, false);

            xhr.open("POST", uri, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $progress.success();
                    } else {
                        errors.push({
                            file: file.name,
                            status: xhr.status,
                            statusText: xhr.statusText
                        });

                        $progress.error(xhr.status + ' ' + xhr.statusText);
                    }
                    --activeUploads;
                }

                if (activeUploads == 0) {
                    if (errors.length) {
                        $dialog.find('.modal-footer').show();
                    } else {
                        if (visible) {
                            $dialog.modal('hide');
                        } else {
                            window.setTimeout(function() {
                                $dialog.modal('hide');
                            }, 700);
                        }
                    }
                }
            };

            fd.append('file', file);

            toFormData(additionalData, fd);

            // Initiate a multipart/form-data upload
            xhr.send(fd);
        }

        function uploadFiles(uri, filesArray, data, finishCallback) {
            var progressList = [];

            onFinish = finishCallback;
            additionalData = data || {};

            reset();

            for (var i=0; i<filesArray.length; i++) {
                progressList[i] = progress(filesArray[i]);
            }

            $dialog.modal();

            for (var i=0; i<filesArray.length; i++) {
                sendFile(filesArray[i], progressList[i]);
            }
        };

        function pickFiles(pickCallback, attrs) {
            $dialog.find('form')[0].reset();
            var picker = $dialog.find('input[name="picker"]');

            if (attrs !== undefined) {
                picker.attr(attrs);
            }

            picker.on('change', function() {
                picker.off('change');
                pickCallback(this.files);
            });

            picker.click();
        }

        return {
            uploadFiles: uploadFiles,
            pickFiles: pickFiles
        }
    }

    window.fileUploader = Uploader();
});
