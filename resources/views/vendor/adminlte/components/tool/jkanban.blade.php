<div id='kanban'></div>
@push('js')
<script>
    var projects = {!! json_encode($projects) !!};
    var kanban = new jKanban({
      element: '#kanban',
      gutter: '10px',
      widthBoard: '350px',
      itemHandleOptions:{
        enabled: true,
      },
      dropEl: function(el, target, source, sibling){
        $.ajax({
            url: '{{ route('updateProject') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                id: el.getAttribute('data-eid'),
                process_status: target.parentElement.getAttribute('data-id'),
            },
            success: function(response) {
                if (response.success) {
                  showToastMessage(true, response.message);

                  setTimeout(function(){
                    var finished = true;
                    var projects = document.querySelectorAll('.kanban-item');
                    projects.forEach(function(project) {
                      if (project.offsetParent.getAttribute('data-id') != '_done') {
                        finished = false;
                      }
                    });
                    if (!finished) {
                      $('#finish-service').hide(500);
                    } else {
                      $('#finish-service').show(500);
                    }
                  }, 1200);
                } else {
                  showToastMessage(false, response.message);
                }
            }
        });
      },
      buttonClick: function(el, boardId) {
        var formItem = document.createElement('form');
        formItem.className = 'itemform';
        var formGroupInput = document.createElement('div');
        formGroupInput.className = 'form-group';
        var inputText = document.createElement('input');
        inputText.type = 'text';
        inputText.className = 'form-control';
        inputText.autofocus = true;
        inputText.setAttribute('placeholder', '{{ __('kanban.enter_a_title') }}');
        inputText.setAttribute('required', true);
        formGroupInput.appendChild(inputText);
        var formGroupButtons = document.createElement('div');
        formGroupButtons.className = 'form-group';
        var submitButton = document.createElement('button');
        submitButton.type = 'submit';
        submitButton.className = 'btn btn-success btn-xs pull-right';
        submitButton.textContent = '{{ __('kanban.add') }}';
        var cancelButton = document.createElement('button');
        cancelButton.type = 'button';
        cancelButton.id = 'btn-cancel';
        cancelButton.className = 'btn btn-danger btn-xs pull-right';
        cancelButton.textContent = '{{ __('kanban.cancel') }}';
        formGroupButtons.appendChild(submitButton);
        formGroupButtons.appendChild(cancelButton);
        formItem.appendChild(formGroupInput);
        formItem.appendChild(formGroupButtons);
        kanban.addForm(boardId, formItem);

        formItem.addEventListener('submit', function(e) {
          e.preventDefault();
          var text = e.target[0].value;
          kanban.addElement(boardId, {
            title: text
          });
          formItem.parentNode.removeChild(formItem);
          $.ajax({
                url: '{{ route('createProject') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    service_id: {{ $service->id }},
                    name: text,
                    process_status: boardId,
                },
                success: function(response) {
                    if (response.success) {
                      showToastMessage(true, response.message);
                      setTimeout(function(){
                        location.reload();
                      }, 1200);
                    } else {
                      showToastMessage(false, response.message);
                    }
                }
            });
        });
        document.getElementById('btn-cancel').onclick = function() {
          formItem.parentNode.removeChild(formItem);
        };
      },
      itemAddOptions: {
        enabled: true,
        content: '{{ __('kanban.add_new_task') }}',
        class: 'btn btn-light btn-sm',
        footer: false
      },
      boards: [
        {
          id: '_todo',
          title: '{{ __('kanban.to_do') }}',
          class: 'kanban-card-header-secondary,text-white,d-flex,justify-content-between',
          dragTo: ['_working'],
          item: []
        },
        {
          id: '_working',
          title: '{{ __('kanban.in_progress') }}',
          class: 'kanban-card-header-info,text-white,d-flex,justify-content-between',
          item: []
        },
        {
          id: '_done',
          title: '{{ __('kanban.done') }}',
          class: 'kanban-card-header-success,text-white,d-flex,justify-content-between',
          dragTo: ['_working'],
          item: []
        }
      ]
    });

    var finished = true;
    if (projects.length == 0) {
      finished = false;
    }
    projects.forEach(function(project) {
      var boardId;
      switch (project.process_status) {
        case 'N':
          boardId = '_todo';
          finished = false;
          break;
        case 'A':
          boardId = '_working';
          finished = false;
          break;
        case 'F':
          boardId = '_done';
          break;
        default:
          boardId = '_todo';
          finished = false;
          break;
      }

      var item = {
        id: project.id,
        title: project.name,
      };
      kanban.addElement(boardId, item);
      var projectActions = document.getElementById('project-actions' + project.id);
      projectActions.setAttribute('class', 'ml-auto');
      var buttonDanger = document.createElement('button');
      buttonDanger.setAttribute('type', 'button');
      buttonDanger.setAttribute('class', 'btn btn-danger btn-sm');
      buttonDanger.setAttribute('data-toggle', 'modal');
      buttonDanger.setAttribute('data-target', '#deleteModal' + project.id);
      buttonDanger.setAttribute('data-id', project.id);
      var iconTrash = document.createElement('i');
      iconTrash.setAttribute('class', 'fas fa-trash');
      buttonDanger.appendChild(iconTrash);
      var buttonInfo = document.createElement('button');
      buttonInfo.setAttribute('type', 'button');
      buttonInfo.setAttribute('class', 'btn btn-info btn-sm');
      buttonInfo.setAttribute('data-toggle', 'modal');
      buttonInfo.setAttribute('data-target', '#imageModal' + project.id);
      buttonInfo.setAttribute('data-id', project.id);
      var iconImage = document.createElement('i');
      iconImage.setAttribute('class', 'fas fa-images');
      buttonInfo.appendChild(iconImage);
      projectActions.appendChild(buttonInfo);
      projectActions.appendChild(buttonDanger);
    });
    if (!finished) {
      $('#finish-service').hide();
    } else {
      $('#finish-service').show();
    }    
  </script>
@endpush