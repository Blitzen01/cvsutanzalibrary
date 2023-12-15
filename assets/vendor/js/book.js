import { } from '../../js/main.js';

var sessionData = JSON.parse(sessionStorage.getItem('session_data'));

// Show header search bar when book search Y position is greater than Yoffset
$(document).ready(function () {
    var opac_search_top = document.getElementById("opac_search_top");
    var opac_search_top_icon = document.getElementById("opac_search_top_icon");
    var opac_search_top_collapse = document.getElementById("opac_search_top_collapse");
    var book_search = document.getElementById("book_search");

    window.addEventListener("scroll", function () {
        var current_offset = window.pageYOffset || document.documentElement.current_offset;

        if (current_offset >= book_search.offsetTop) {
            opac_search_top.style.visibility = "visible";
            opac_search_top_icon.style.visibility = "visible";
            opac_search_top_collapse.style.visibility = "visible";
        } else {
            opac_search_top.style.visibility = "hidden";
            opac_search_top_icon.style.visibility = "hidden";
            opac_search_top_collapse.style.visibility = "hidden";
        }
    })
});
// Show header search bar when book search Y position is greater than Yoffset


// Function for books datatables
$(document).ready(function () {
    let books_table = new DataTable('#books_table', {
        // ajax: '../../../php_script/server_processing.php', // DO NOT REMOVE
        processing: true, // DO NOT REMOVE
        // serverSide: true, // DO NOT REMOVE
        ajax: '../../../ajax/data/books.txt',
        responsive: true,
        iDisplayLength: 20,
        columnDefs: [
            {
                targets: -1,
                data: null,
                render: function (data, type, row) {
                    let value = row[14];

                    if (value === "Available to Borrow") {
                        return "<button id='request_btn' showModal('login_reminder_modal') class='btn btn-outline-primary fs-5 w-50'>REQUEST</button>";
                    } else {
                        return "<button class='btn btn-outline-secondary fs-5 w-50' disabled>Not Available</button>";
                    }
                }
            },
            {
                "targets": -2,
                "render": function (data, type, row) {
                    let value = row[14];
                    if (value === "Available to Borrow") {
                        return "<h4 class='fst-italic text-primary'>" + data + "</h4>";
                    } else {
                        return "<h4 class='fst-italic text-secondary'>" + data + "</h4>";
                    }
                }
            }
        ],
        "createdRow": function (row, data, index) {
            let value = data[14];

            if (value == "Available to Borrow") {
                $('#request_btn', row).prop('disabled', false);
                $('td', row).addClass('available');
            } else {
                $('#request_btn', row).prop('disabled', true);
                $('td', row).addClass('notAvailable');
            }
        },
    });

    $('.pageLengthSelect').on('change', function () {
        var newPageLength = $(this).val();
        books_table.page.len(newPageLength).draw();
    });

    $('#search_books_input').keyup(function () {
        books_table.search($(this).val()).draw();
    })

});
// Function for books datatables


$(function () {
    $('#books_table tbody').on('click', '[id*=request_btn]', function () {
        if (sessionData) {
            if (sessionData.user_token != null) {
                $('#book_request_form_modal').modal('show');
            }
        } else {
            $('#login_reminder_modal').modal('show');
        }
    });
});

// $('#books_table tbody').on('click', 'tr', function () {
//     alert($(this).find('td:first').text());
// });


// "<h4 id='availability_label' class='available fst-italic text-primary'>Available to Borrow</h4>",
// "<button id='availability_btn' class='btn fs-5 px-3 py-1 my-2' onclick='myFunction()'>REQUEST</button>"