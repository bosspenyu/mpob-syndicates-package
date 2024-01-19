import './bootstrap.js';
import 'admin-lte';
import 'daterangepicker'
import Dropzone from 'dropzone';

//Initial Select2 & SwitchButton
$('.select2').select2()
$('.switch-style').bootstrapSwitch()
$('[data-toggle="tooltip"]').tooltip()
$('#reservationdate').daterangepicker({
    singleDatePicker: true,
}).on('apply.daterangepicker', function (ev, picker) {
    $('.datetimepicker-input').val(picker.startDate.format('YYYY-MM-DD'))
});
$('#advance_search').on('hidden.bs.collapse', function () {
    $('.advance_search').val(false)
})
$('#advance_search').on('show.bs.collapse', function () {
    $('.advance_search').val(true)
})
//End of Initial


//Select2 Tags
$('.tags').select2({
    tags: true, createTag: newtag,
    matcher: matchCustom
})
function newtag(params, data) {
    var term = $.trim(params.term).replace(/\s/g, "");
    if (term === "") {
        return null;
    }

    // duplicate check
    var selectedTags = $(".tags").val() || [];
    if (selectedTags.indexOf(term) > -1) {
        return null;
    }

    return {
        id: term,
        text: '#' + term,
        newTag: true // add additional parameters
    };
}
function matchCustom(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
        return data;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
        return null;
    }

    // Return `null` if the term should not be displayed
    return null;
}
//End Of Select2 Tags


//Syndicate Profile Image Upload
$('.profile-image').on('click', function () {
    $('.syndicate-profile-image').click();
});
window.previewFile = function () {
    let preview = document.querySelector('.profile-image');
    let file = document.querySelector('input[type=file]').files[0];
    let reader = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}
//End of Syndicate Profile Image Upload


//Tab Active
const activeTab = localStorage.getItem('activeTab');
$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
});
if (activeTab) {
    $('#myTab a[href="' + activeTab + '"]').tab('show');
}
//End of Tab Active


//Upload Image/Files
Dropzone.options.fileUploader = {
    parallelUploads: 1,
    addRemoveLinks: true,

    init: function () {
        this.on("error", function (file, responseText) { //the status from the response is 400
            var status = $(file.previewElement).find('.dz-error-message');
            status.text(responseText.message);
            status.show();

            var msgContainer = $(file.previewElement).find('.dz-image');
            msgContainer.css({"border": "2px solid #d90101"}) //red border if fail
        });

        this.on("removedfile", function (file) {
            // check if the file is uploaded or not. If uploaded we remove it from the server, otherwise we do nothing
            //because it isn't uploaded
            if ($(file.previewElement).hasClass('dz-error')) return;

            var noteId = $(file.previewElement).find('.dz-remove').data("dz-note-id")
            var syndicateId = $(file.previewElement).find('.dz-remove').data("dz-syndicate-id")
            var mediaId = $(file.previewElement).find('.dz-remove').data("dz-media-id")

            $.post({
                type: 'DELETE',
                url: `/syndicates/${syndicateId}/notes/${noteId}/file/destroy`,
                data: {media_id: mediaId, _token: $('[name="_token"]').val()},
                success: function (result) {
                    if (!result) alert("Error! Contact the admin") // add your code if error
                }
            });
        });
    },
    success: function (file, response) {  //the status from the response is 200
        var msgContainer = $(file.previewElement).find('.dz-image');
        msgContainer.css({"border": "2px solid #38873C"}) //green border

        //set id file to remove link function
        var removeLink = $(file.previewElement).find('.dz-remove')
        removeLink.attr("data-dz-syndicate-id", response.syndicateId);
        removeLink.attr("data-dz-note-id", response.note.id_);
        removeLink.attr("data-dz-media-id", response.media.id);
    },
};
const _array = [];
const _uploadAction = $('#uploadingDocs').data('action')
const _deleteAction = $('#uploadedDocs').data('action')
const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
window.remove = function (link) {
    var noteId = link.getAttribute('data-note-id')
    var syndicateId = link.getAttribute('data-syndicate-id')
    var mediaId = link.getAttribute('data-media-id')
    $.post({
        type: 'DELETE',
        url: `/syndicates/${syndicateId}/notes/${noteId}/file/destroy`,
        data: {media_id: mediaId, _token: $('[name="_token"]').val()},
        success: function (result) {
            if (!result) {
                alert("Error! Contact the admin")
            } else {
                $(`.note-list-images > .image-${mediaId}`).remove()
            }
        }
    });

    return false;
}
window.previewDocs = function () {
    let reader = new FileReader();
    let file = document.querySelector('input[name=documents]').files[0];
    let document_name = $('input[name=document_name]')

    if (document_name.val() === "") {
        document.querySelector('input[name=documents]').value = ""
        alert('Masukkan nama dokumen')

        return false
    }

    if (file) {
        reader.readAsDataURL(file)
    }

    _array.push({name: document_name.val(), document: file, date: new Date().toJSON().slice(0, 10)})

    let countData = _array.length
    let last = _array.slice(-1)[0]
    //jika perlu
    //let getExt = last.document.type.split('/')
    //let extFile = getExt[getExt.length - 1]

    $("#uploadingDocs").find('tbody')
        .append(
            $(`<tr>`)
                .append($('<td>').html(countData))
                .append($('<td>').html(last.name))
                .append($('<td>').html(last.document.name))
                .append($('<td>').html(last.date))
                .append($('<td class="text-center">').html(
                    `<button class="btn btn-xs btn-danger" onclick="deleteRow(this,'uploadingDocs')"><i class="fa fa-trash"></i></button>
                <button class="btn btn-xs btn-success" onclick="uploadDoc(${countData - 1}, this)"><i class="fa fa-upload"></i></button>`
                ))
        )

    document.querySelector('input[name=documents]').value = ""
    document_name.val("")
}
window.deleteRow = function (ele, tableId) {
    console.log(ele)
    let table = document.getElementById(tableId);
    let rowCount = table.rows.length;
    if (rowCount <= 1) {
        alert("There is no row available to delete!");
        return;
    }
    if (ele) {
        //delete specific row
        ele.parentNode.parentNode.remove();
    } else {
        //delete last row
        table.deleteRow(rowCount - 1);
    }
}
window.uploadDoc = function (key, ele) {

    let file = _array[key].document
    let name = _array[key].name

    let formData = new FormData()

    formData.append('file', file)
    formData.append('name', name)

    axios.post(_uploadAction, formData)
        .then(function (response) {
            console.log(response)
            $('#alert').removeClass('d-none')
            $('#alert').find('.alert').html(response.message)
            deleteRow(ele, 'uploadingDocs')

            let countData = $('#uploadedDocs tbody tr').length + 1
            $("#uploadedDocs").find('tbody')
                .append(
                    $(`<tr>`)
                        .append($('<td>').html(countData))
                        .append($('<td>').html(response.data.data.name))
                        .append($('<td>').html(response.data.data.name))
                        .append($('<td>').html(response.data.data.createdAt))
                        .append($('<td class="text-center">').html(
                            `<button class="btn btn-xs btn-danger docDelete" data-media-id="${response.data.id}" data-media-action="{{ route('documents.delete', $syndicate->id) }}"><i class="fa fa-trash"></i></button>
                             <button class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></button>`
                        ))
                )
        })
        .catch(function (error) {
            console.log(error)
        })
}
window.uploadDocs = function () {
    _array.forEach(function (value, index) {
        uploadDoc(index)
    })
}
$(document).on('click', '.docDelete', function () {
    let _this = $(this)
    let formData = new FormData()
    let mediaId = _this.data('media-id')

    formData.append('media_id', mediaId)
    formData.append('_method', 'delete')

    axios.post(_deleteAction, formData)
        .then(function (data) {
            $('#alert').removeClass('d-none')
            $('#alert').find('.alert').html(data.message)
            console.log(data)
            deleteRow(_this[0], 'uploadedDocs')
        })
        .catch(function (error) {
            console.log(error)
        })
})
//End Of Upload Image/Files

