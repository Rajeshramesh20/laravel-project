//for subject dropdown
function multiDropdown() {
    const dropdown = document.getElementById('dropdownList');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('click', function (e) {
    const dropdown = document.getElementById('dropdownList');
    const btn = document.querySelector('.dropdown-btn');
    if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});

//for groups dropdown
function toggleMultiselect() {
    const container = document.getElementById('multiselectContainer');
    container.style.display = (container.style.display === 'block') ? 'none' : 'block';
}

document.addEventListener('click', function (e) {
    const wrapper = document.querySelector('.custom-multiselect-wrapper');
    if (!wrapper.contains(e.target)) {
        document.getElementById('multiselectContainer').style.display = 'none';
    }
});


//for download button
function toggleDropdown(id) {
    var dropdown = document.getElementById(id);
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';

}
// excel export modal
document.addEventListener('DOMContentLoaded', function () {
    exportExcelStatus();
    const modal = document.getElementById("myModal");
    const openBtn = document.getElementById("openModalBtn");
    const closeBtn = document.getElementById("closeModalBtn");

    openBtn.onclick = () => {
        modal.style.display = "block";
    }

    closeBtn.onclick = () => {
        modal.style.display = "none";
    }

    window.onclick = (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

//get the token to localstorage
const token = localStorage.getItem("token");

//student list with Pagination
let currentPage = 1;

let searchdatapaginate = false;


document.addEventListener('DOMContentLoaded', function () {
    loadStudents(currentPage);
});


function loadStudents(page = 1) {
    currentPage = page;
    if (!token) {
        alert("No token found. Please login first.");
        window.location.href = "/api/login";
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('GET', `http://127.0.0.1:8000/api/getdata?page=${page}`, true);
    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
    xhr.setRequestHeader('Accept', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            const tbody = document.getElementById('tbody');
            tbody.innerHTML = '';
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const students = response.data;
                const canDelete = response.user.can_delete;
                const canAddpermission = response.user.role;
                const canedit = response.user.can_edit;
                const canAddStudent = response.user.can_addStudent;
                const canImport = response.user.can_import;
                const canmail = response.user.can_mail;
                const canexport = response.user.can_export;
                if (!canAddStudent) {
                    document.getElementById('createBtn').style.display = 'none';
                }
                if (!canImport) {
                    document.getElementById('importForm').style.display = 'none';
                   
                }
                if (!canmail) {
                     document.getElementById('sendmail').style.display = 'none';
                }
                if (!canexport) {
                    document.getElementById('dowloadBtn').style.display = 'none';
                }
                if (canAddpermission !== "superadmin") {
                    document.getElementById('permissionBtn').style.display = 'none';
                }
                currentPage = response.meta.current_page;
                studentTable(students, canDelete,canedit);
                generatePagination(response.meta.last_page);
            }
            else if (xhr.status === 403) {
                alert('  your unauthorized  to viwe list');
            }
            else {
                const row = document.createElement('tr');
                row.innerHTML = `<td >Error loading data: ${xhr.statusText}</td>`;
                tbody.appendChild(row);
            }
        }
    };
    xhr.send();
}

//generatePagination

function generatePagination(lastPage) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    for (let i = 1; i <= lastPage; i++) {
        const btn = document.createElement('button');
        btn.innerText = i;
        btn.className = 'page-btn' + (i === currentPage ? ' active' : '');

        btn.addEventListener('click', function () {

            if (searchdatapaginate) {
                search(i);
            }else{
                loadStudents(i);
            }

        });

        paginationContainer.appendChild(btn);
    }
}

//student table tbody for list and search
function studentTable(students, canDelete,canedit) {
    const tbody = document.getElementById('tbody');
    students.forEach(student => {
        const row = document.createElement('tr');
        const subjects = student.subjects.map(sub => sub.subjectname).join('<br>');
        const group = student.group ? student.group.groupname : '';

        const thAction = document.querySelector('th.actionBtnCol');

  if (thAction) {
        thAction.style.display = (canedit || canDelete) ? '' : 'none';
    }

        let actionButtons = " ";

        if (canedit) {
            actionButtons += 
            `
        <button class="edit-btn edite" data-id="${student.id}">
            <i class='fas fa-edit' title='Edit'></i>
        </button>
    `;       
        }
    
        if (canDelete) {
            actionButtons += `
            <button class="delete-btn delete" data-id="${student.id}">
                <i class='fas fa-trash' title='Delete'></i>
            </button>
        `;
           ;
        }

        const actionCell = (canedit || canDelete)
            ? `<td class="actionBtnCol">${actionButtons}</td>`
            : '';

        row.innerHTML = `
        <td>${student.id}</td>
        <td>${student.firstname}</td>
        <td>${student.lastname}</td>
        <td>${student.email}</td>
        <td>${student.age}</td>
        <td>${student.gender}</td>
        <td>${student.date_of_birth}</td>
        <td>${student.mobile_number}</td>
        <td>${student.class}</td>
        <td>${student.batch}</td>
        <td>${student.medium}</td>
        <td>${group}</td>
        <td>${subjects}</td>
      ${actionCell}
    `;
        tbody.appendChild(row);
    });
}

//edit & delete
document.addEventListener('click', function (e) {

    if (e.target.closest('.edit-btn')) {
        const studentId = e.target.closest('.edit-btn').dataset.id;
        // Redirect to edit page with studentId as query param
        window.location.href = `/api/studentEditForm/${studentId}`;
    }

    if (e.target.closest('.delete-btn')) {
        const studentId = e.target.closest('.delete-btn').dataset.id;
        if (confirm(`Are you sure you want to delete student ID ${studentId}?`)) {
            const xhr = new XMLHttpRequest();
            xhr.open('DELETE', `http://127.0.0.1:8000/api/delete/${studentId}`, true);
            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const data = JSON.parse(xhr.responseText);
                        if (data.success) {
                            alert(data.message);
                            loadStudents(currentPage);
                        } else {
                            alert('Error deleting student: ' + data.message);
                        }
                    }
                    else if (xhr.status === 403) {
                        alert(' your unauthorized  to delete'); 
                    }
                    else {
                        alert('Request failed with status: Only superadmin can delete students.');
                    }
                }
            };

            xhr.send();
        }
    }
});

// search or pdf export
function searchAndPdf() {
    const firstname = document.getElementById('firstname').value;
    const lastname = document.getElementById('lastname').value;
    const email = document.getElementById('email').value;

    const selectedSubjects = Array.from(document.querySelectorAll('#dropdownList input[type="checkbox"]:checked'))
        .map(cb => cb.value);

    const selectedGroups = Array.from(document.getElementById('groupDropdown').selectedOptions)
        .map(opt => opt.value);

    const page = 1;

    const params = new URLSearchParams({
        page: page
        , firstname: firstname
        , lastname: lastname
        , email: email
    });

    selectedGroups.forEach(id => params.append('group_ids[]', id));
    selectedSubjects.forEach(id => params.append('subject_ids[]', id));
    return params;
}

function search(page=1) {
    let paramsdata = searchAndPdf();
    paramsdata.set('page', page);
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `http://127.0.0.1:8000/api/search?${paramsdata.toString()}`, true);
    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            const tbody = document.getElementById('tbody');
            tbody.innerHTML = '';
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const students = response.data;
                const canDelete = response.user.can_delete;
                const canedit = response.user.can_edit;
                currentPage = response.meta.current_page;

                
                studentTable(students, canDelete, canedit);
                generatePagination(response.meta.last_page);
                searchdatapaginate = true;

            }
            else if (xhr.status === 403) {
                alert('your unauthorized  to search');
            }
            else {
                const row = document.createElement('tr');
                row.innerHTML = `<td colspan="5">Error loading data: ${xhr.statusText}</td>`;
                tbody.appendChild(row);
            }
        }
    };
    xhr.send();
}


//
document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const clickedButton = e.submitter;

  
    if (clickedButton.id === 'searchBtn') {
        let paramsdata = searchAndPdf();
        paramsdata.append('page', 1);
        search(1);

        // params.append('page', 1);
      
    } else if (clickedButton.id === 'downloadPdfBtn') {
        let paramsdata = searchAndPdf();
        paramsdata.append('action', 'pdf');

        const xhr = new XMLHttpRequest();
        xhr.open('GET', `http://127.0.0.1:8000/api/search?${paramsdata.toString()}`, true);
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        xhr.setRequestHeader('Accept', 'application/pdf');
        xhr.responseType = 'blob';

        xhr.onload = function () {
            if (xhr.status === 200) {
                const blob = new Blob([xhr.response], {
                    type: 'application/pdf'
                });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'students.pdf';
                link.click();
                URL.revokeObjectURL(link.href);
            }
            else if (xhr.status === 403) {
                alert(' your unauthorized  to download pdf');
            }
            else {
                alert('PDF download failed');
            }
        };

        xhr.send();

    }
});


//export excel
function downloadExcelFile() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://127.0.0.1:8000/api/excel', true);
    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.status) {
                    alert(response.message);
                    console.log("Export Info:", response.data);
                } else {
                    alert("Export failed: " + response.message);
                }
            }
            else if (xhr.status === 403) {
                alert(' your unauthorized  to export');
            }
            else {
                alert("Request failed: " + xhr.statusText);
            }
        }
    };
    xhr.send();
}


// export excel statues 
function exportExcelStatus() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'http://127.0.0.1:8000/api/export-history', true);
    xhr.setRequestHeader('Authorization', 'Bearer ' + token);
    xhr.setRequestHeader('Accept', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            const tbody = document.getElementById('exportHistoryBody');
            tbody.innerHTML = '';

            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                response.data.forEach(task => {
                    const row = document.createElement('tr');

                    const downloadLink = task.status === 'completed' ?
                        `<a href="/storage/exports/${task.file_name}" download><i class="fas fa-download"></i> Download</a>` :
                        '';

                    row.innerHTML = `
                <td>${task.id}</td>
                <td>${task.user?.name ?? ''}</td>
                <td>${task.file_name}</td>
                <td>${task.status}</td>
                <td>${task.initiated_at ?? ''}</td>
                <td>${task.completed_at ?? ''}</td>
                <td>${downloadLink}</td>
                 `;

                    tbody.appendChild(row);
                });

            }
            // else if (xhr.status === 403) {
            //     alert('your unauthorized  to view export history');
            // }
            else {
                const row = document.createElement('tr');
                row.innerHTML = `<td colspan="6">Failed to load export history</td>`;
                tbody.appendChild(row);
            }
        }
    };

    xhr.send();

}

//import excel
function submitImport(actionType) {
    console.log('submitImport called with:', actionType); 
    const form = document.getElementById('importForm');
    const file = document.getElementById('file');

    if (file.files.length === 0) {
        alert("Please select a file first.");
        return;
    }
    const formData = new FormData(form);

    formData.append('file', file.files[0]);
    formData.append('action', actionType);
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost:8000/api/import', true);
    xhr.setRequestHeader('Authorization', 'Bearer ' + token);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                alert('Import successful!');
                console.log(xhr.responseText);
            } else if (xhr.status === 403) {
                alert(' your unauthorized  to import student');
            } else {
                alert('Import failed: ' + xhr.statusText);
                console.error(xhr.responseText);
            }
        }
    };

    xhr.send(formData);
}

//import dropdown
function toggleImportDropdown() {
    var importdropdown = document.getElementById('importDropdown');
    importdropdown.style.display = importdropdown.style.display === 'none' ? 'block' : 'none';
}



//group dropdown
const groupname = ["Biology", "Computer Science", "Commerce", "Computer Application", "Business Maths"];
const groupcontainer = document.getElementById("groupDropdown");
groupname.forEach((group, index) => {
    const option = document.createElement('option');
    option.value = index + 1; 
    option.textContent = group;
    groupDropdown.appendChild(option);

})


//subject dropdown
const subjects = ["Tamil", "Kannada", "Malayalam", "Telugu", "Hindi", "Sanskrit", "French"];
const container = document.getElementById("dropdownList");

subjects.forEach((subject, index) => {
    const value = index + 1;
    const checkbox = `<label class="dropdown-item" ><input type="checkbox" name="subjects[]" value="${value}"> ${subject}</label>`;
    container.innerHTML += checkbox;

});

//logout
document.getElementById('logoutBtn').addEventListener('click', function () {
    if (!confirm("Are you sure you want to logout?")) return;
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "http://127.0.0.1:8000/api/logout", true);
    xhr.setRequestHeader("Authorization", "Bearer " + token);
    xhr.setRequestHeader("Accept", "application/json");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                localStorage.removeItem("token");
                alert("Logout successful");
                window.location.href = "/api/login";
            } else {
                alert("Logout failed");
            }
        }
    };
    xhr.send();
});

// roles  menu modal 
function openListModal(heading,api) {
    document.getElementById("headding").innerText = heading;
    document.getElementById("dataModal").style.display = "block";

    const xhr = new XMLHttpRequest();
    xhr.open("GET", api, true);
    xhr.setRequestHeader("Accept", "application/json");

    const token = localStorage.getItem("token");
    if (token) {
        xhr.setRequestHeader("Authorization", "Bearer " + token);
    }

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const res = JSON.parse(xhr.responseText);
                if (res.status && Array.isArray(res.data)) {
                    populateSimpleTable(res.data);
                } else {
                    alert("No data found.");
                }
            } else {
                alert("Failed to load data.");
            }
        }
    };

    xhr.send();
}

function populateSimpleTable(items) {
    const tbody = document.getElementById("modalTableBody");
    tbody.innerHTML = '';

    items.forEach(item => {
        const row = document.createElement("tr");
        row.innerHTML = `<td>${item.id}</td>
        <td>${item.name}</td>`;
        tbody.appendChild(row);
    });
}

function closeModal() {
    document.getElementById("dataModal").style.display = "none";
}
  
const roleUrl = "http://127.0.0.1:8000/api/roleList";
const menuUrl = "http://127.0.0.1:8000/api/menuList";
const permissionurl = "http://127.0.0.1:8000/api/MenuPermissionList";