@extends('layouts.app')
@section('style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/student_list.css') }}">
<style>
            #pagination {
        margin-top: 20px;
    }
    .page-btn {
        padding: 5px 20px;
        margin: 0 3px;
        cursor: pointer;
        border: 1px solid #ccc;
        background-color: white;
        border-radius: 4px;
        font-size: 14px;
    }
    .page-btn.active {
        background-color: #333;
        color: white;
        font-weight: bold;
        border-color: #ccc;
    }
    .pageDiv{
      text-align: center;
    }
</style>
@endsection
@section('content')

@if (session('success'))
<div>
    {{ session('success') }}
</div>
@endif
<div class="back">
    <a href="{{route('api.studentList')}}" class="table_view table_btn" >back</a>
</div>

<h1>Student Mark Table</h1>
<table>
    <thead>
        <tr>
        <th rowspan="2" >Student id</th>   
        <th rowspan="2">Student Name</th>
        <th rowspan="2">Group </th>
        <th colspan="7">Subjects</th>
        <th rowspan="2">Total</th>
        <th rowspan="2">Percentage</th>
    </tr>

    <tr>
        <th>Tamil</th>
        <th>Kannada</th>
        <th>Malayalam</th>
        <th>Telugu</th>
        <th>Hindi</th>
        <th>Sanskrit</th>
        <th>French</th>
    </tr>

</thead>
<tbody id="MarkTableBody"></tbody>
<tfoot  id="tfoot">
</tfoot> 
</table>
<div id="pagination" class="pageDiv"></div>

<script>
    let currentPage = 1;
      document.addEventListener('DOMContentLoaded', function () {
        loadStudents(currentPage);
    });
    function loadStudents(page = 1) {
        currentPage = page;
     const token = localStorage.getItem("token"); 

 
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `http://localhost:8000/api/getmark?page=${page}`, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);   
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.onload = function () {
            if (xhr.readyState === 4) {
                const tbody = document.getElementById('MarkTableBody');
                tbody.innerHTML = '';
               
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const studentsMark = response.data;

                currentPage = studentsMark.mark.current_page;
                
                generatePagination(studentsMark.mark);
                // console.log(studentsMark);
                const studentsMarks = studentsMark.mark.data;
                const subjectaverage = studentsMark.sub_average; 
                const subjectTotal =  studentsMark.subject;

                // console.log(studentsMarks);
                
                studentsMarks.forEach(students => {
                    const row = document.createElement('tr');
                     row.innerHTML = `
                        <td class="align">${students.id}</td>
                        <td >${students.name}</td>
                        <td >${students.group}</td>
                        <td class="align">${students.marks.tamil}</td>
                        <td class="align">${students.marks.Kannada}</td>
                        <td class="align">${students.marks.Malayalam}</td>
                        <td class="align">${students.marks.Telugu}</td>
                        <td class="align">${students.marks.Hindi}</td>
                        <td class="align">${students.marks.Sanskrit}</td>
                        <td class="align">${students.marks.French}</td>
                        <td class="align">${students.total}</td>
                        <td class="align">${students.average}%</td>
                       `;
                        tbody.appendChild(row);
               });
               const tfoot= document.getElementById('tfoot');
               tfoot.innerHTML = '';
               const rowavg = document.createElement('tr');
               const rowtotal = document.createElement('tr');

               rowtotal.innerHTML = `<th colspan="3">Total Mark In Subject Wise</th>`;
               tbody.appendChild(rowtotal);
                 
               for (let subtotal in subjectTotal ) {
                rowtotal.innerHTML +=`<th class="align">${subjectTotal[subtotal]}</th>`;
                       
               }
               tbody.appendChild(rowtotal);

               rowavg.innerHTML = `<th colspan="3">Average In Subject Wise</th>`;
               tbody.appendChild(rowavg);
               for (let average in subjectaverage ) {
                rowavg.innerHTML +=`<th class="align">${subjectaverage[average]}</th>`;
                       
               }
               tbody.appendChild(rowavg);
            }
        }
    }
    xhr.send();
}
function generatePagination(lastPage) {
        const paginationContainer = document.getElementById('pagination');
        paginationContainer.innerHTML = '';

        for (let i = 1; i <= lastPage.last_page; i++) {
            const btn = document.createElement('button');
            btn.innerText = i; 
            btn.className = 'page-btn' + (i === currentPage ? ' active' : '');

            btn.addEventListener('click', function () {
            
                if (currentPage !== i) {
                    loadStudents(i);
                }
            });

            paginationContainer.appendChild(btn);
        }
    }

    </script>
@endsection