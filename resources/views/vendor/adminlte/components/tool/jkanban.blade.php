<style>
    body {
      font-family: "Lato";
      margin: 0;
      padding: 0;
    }

    #myKanban {
      overflow-x: auto;
      padding: 20px 0;
    }

    .success {
      background: #00b961;
    }

    .info {
      background: #2a92bf;
    }

    .warning {
      background: #f4ce46;
    }

    .error {
      background: #fb7d44;
    }

    .custom-button {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 7px 15px;
      margin: 10px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
    }      
</style>
<div id="kanban"></div>
@push('js')
<script>
    var projects = {!! json_encode($projects) !!};
    var kanban = new jKanban({
      element: "#kanban",
      gutter: "10px",
      widthBoard: "350px",
      itemHandleOptions:{
        enabled: true,
      },
      dropEl: function(el, target, source, sibling){
        $.ajax({
            url: "{{ route('updateProject') }}",
            type: "POST",
            dataType: "json",
            data: {
                id: el.getAttribute('data-eid'),
                process_status: target.parentElement.getAttribute('data-id'),
            },
            success: function(response) {
                if (response.success) {
                  Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1200
                    })
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1200
                    })
                }
            }
        });
      },
      buttonClick: function(el, boardId) {
        var formItem = document.createElement("form");
        formItem.setAttribute("class", "itemform");
        formItem.innerHTML =
          '<div class="form-group"><textarea class="form-control" rows="2" autofocus></textarea></div><div class="form-group"><button type="submit" class="btn btn-primary btn-xs pull-right">Submit</button><button type="button" id="CancelBtn" class="btn btn-default btn-xs pull-right">Cancel</button></div>';
        kanban.addForm(boardId, formItem);
        formItem.addEventListener("submit", function(e) {
          e.preventDefault();
          var text = e.target[0].value;
          kanban.addElement(boardId, {
            title: text
          });
          formItem.parentNode.removeChild(formItem);
          $.ajax({
                url: "{{ route('createProject') }}",
                type: "POST",
                dataType: "json",
                data: {
                    service_id: {{ $service->id }},
                    name: text,
                    process_status: boardId,
                },
                success: function(response) {
                    if (response.success) {
                      Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1200
                      })
                      setTimeout(function(){
                        location.reload();
                      }, 1200);
                    } else {
                        Swal.fire({
                          position: 'top-end',
                          icon: 'error',
                          title: response.message,
                          showConfirmButton: false,
                          timer: 1200
                        })
                    }
                }
            });
        });
        document.getElementById("CancelBtn").onclick = function() {
          formItem.parentNode.removeChild(formItem);
        };
      },
      itemAddOptions: {
        enabled: true,
        content: "+ {{ __('kanban.add_new_task') }}",
        class: 'custom-button',
        footer: true
      },
      boards: [
        {
          id: "_todo",
          title: "{{ __('kanban.to_do') }}",
          class: "info,good",
          dragTo: ["_working"],
          item: []
        },
        {
          id: "_working",
          title: "{{ __('kanban.in_progress') }}",
          class: "warning",
          item: []
        },
        {
          id: "_done",
          title: "{{ __('kanban.done') }}",
          class: "success",
          dragTo: ["_working"],
          item: []
        }
      ]
    });

    projects.forEach(function(project) {
      var boardId;
      switch (project.process_status) {
        case "N":
          boardId = "_todo";
          break;
        case "A":
          boardId = "_working";
          break;
        case "F":
          boardId = "_done";
          break;
        default:
        boardId = "_todo";
          break;
      }

      var item = {
        id: project.id,
        title: project.name,
      };
      kanban.addElement(boardId, item);
      var projectActions = document.getElementById("project-actions" + project.id);
      projectActions.setAttribute("class", "ml-auto");
      var button = document.createElement("button");
      button.setAttribute("type", "button");
      button.setAttribute("class", "btn btn-danger btn-sm");
      button.setAttribute("data-toggle", "modal");
      button.setAttribute("data-target", "#deleteModal" + project.id);
      button.setAttribute("data-id", project.id);
      var icon = document.createElement("i");
      icon.setAttribute("class", "fas fa-trash");
      button.appendChild(icon);
      projectActions.appendChild(button);
    });

    var removeElement = document.getElementById("removeElement");
    removeElement.addEventListener("click", function() {
      kanban.removeElement("_test_delete");
    });

    var allEle = kanban.getBoardElements("_todo");
    allEle.forEach(function(item, index) {
      //console.log(item);
    });

    // add buttons on project actions
  </script>
@endpush