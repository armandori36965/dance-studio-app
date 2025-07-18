import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import flatpickr from "flatpickr";

class CalendarManager {
    constructor(calendarEl, modalEl) {
        this.calendarEl = calendarEl;
        this.modalEl = modalEl;
        this.courseModal = new bootstrap.Modal(this.modalEl);
        this.modalBody = this.modalEl.querySelector('.modal-body');

        // 建立 Calendar 實例
        this.calendar = new Calendar(this.calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: "dayGridMonth",
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth",
            },
            events: this.calendarEl.dataset.eventsUrl,
            // 將事件處理委託給 Class 的方法
            dateClick: this.handleDateClick.bind(this),
            eventClick: this.handleEventClick.bind(this),
        });
    }

    // 啟動日曆
    init() {
        this.calendar.render();
    }

    // 處理日期點擊 (新增)
    handleDateClick(info) {
        const date = info.dateStr;
        window.location.href = `/admin/courses/create?date=${date}`;
    }

    // 處理事件點擊 (編輯/刪除)
    handleEventClick(info) {
        const courseId = info.event.id;
        this.modalBody.innerHTML = '<p>正在載入表單...</p>';
        this.courseModal.show();

        fetch(`/admin/courses/${courseId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this._renderForm(data);
                    this._initFlatpickr();
                    this._attachFormListeners();
                }
            })
            .catch(error => {
                this.modalBody.innerHTML = '<p class="text-danger">載入資料失敗。</p>';
                console.error('Error:', error);
            });
    }

    // (私有方法) 渲染表單 HTML
    _renderForm(data) {
        let formHtml = `

                    <form id="editCourseForm" action="/admin/courses/${data.course.id}" method="POST">

                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">

                        <input type="hidden" name="_method" value="PUT">

                        <div class="mb-3">

                            <label for="edit_template_id" class="form-label">課程模板</label>

                            <select class="form-select" id="edit_template_id" name="template_id">

                                ${data.templates.map(t => `<option value="${t.id}" ${data.course.template_id == t.id ? 'selected' : ''}>${t.name}</option>`).join('')}

                            </select>

                        </div>

                        <div class="mb-3">

                            <label for="edit_teacher_id" class="form-label">授課老師</label>

                            <select class="form-select" id="edit_teacher_id" name="teacher_id">

                                ${data.teachers.map(t => `<option value="${t.id}" ${data.course.teacher_id == t.id ? 'selected' : ''}>${t.name}</option>`).join('')}

                            </select>

                        </div>

                        <div class="mb-3">

                            <label for="edit_location_id" class="form-label">上課地點</label>

                            <select class="form-select" id="edit_location_id" name="location_id">

                                ${data.schools.map(s => `<option value="${s.id}" ${data.course.location_id == s.id ? 'selected' : ''}>${s.name}</option>`).join('')}

                            </select>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label for="edit_date" class="form-label">課程日期</label>

                                <input type="date" class="form-control" id="edit_date" name="date" value="${data.course.date}">

                            </div>

                            <div class="col-md-3 mb-3">

                                <label for="edit_start_time" class="form-label">開始時間</label>

                                <input type="text" class="form-control timepicker" id="edit_start_time" name="start_time" value="${data.course.start_time.substr(0, 5)}">

                            </div>

                            <div class="col-md-3 mb-3">

                                <label for="edit_end_time" class="form-label">結束時間</label>

                                <input type="text" class="form-control timepicker" id="edit_end_time" name="end_time" value="${data.course.end_time.substr(0, 5)}">

                            </div>

                        </div>

                    </form> <div class="modal-footer justify-content-between">

                        <div>

                            <form id="deleteCourseForm" action="/admin/courses/${data.course.id}" method="POST">

                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">

                                <input type="hidden" name="_method" value="DELETE">

                                <button type="submit" class="btn btn-danger">刪除課程</button>

                            </form>

                        </div>

                        <div>

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>

                            <button type="submit" form="editCourseForm" class="btn btn-primary">儲存變更</button>

                        </div>

                    </div>

                `; // 這裡的 HTML 內容跟之前完全一樣
        this.modalBody.innerHTML = formHtml;
    }

    // (私有方法) 初始化 Flatpickr
    _initFlatpickr() {
        flatpickr(".timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minTime: "07:00",
            maxTime: "22:00",
            minuteIncrement: 10,
        });
    }

    // (私有方法) 為 Modal 中的表單加上監聽器
    _attachFormListeners() {
        const editForm = document.getElementById('editCourseForm');
        if (editForm) {
            editForm.addEventListener('submit', (e) => this._handleFormSubmit(e, this.calendar));
        }

        const deleteForm = document.getElementById('deleteCourseForm');
        if (deleteForm) {
            deleteForm.addEventListener('submit', (e) => this._handleFormSubmit(e, this.calendar));
        }
    }

    // (私有方法) 處理表單提交 (編輯與刪除共用)
    _handleFormSubmit(e, calendar) {
        e.preventDefault();
        const form = e.target;

        const confirmAction = () => {
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    this.courseModal.hide();
                    calendar.refetchEvents();
                }
            })
            .catch(error => console.error('Error:', error));
        };

        if (form.id === 'deleteCourseForm') {
            if (confirm('確定要刪除這堂課嗎？')) {
                confirmAction();
            }
        } else {
            confirmAction();
        }
    }
}

// 當網頁載入完成後，執行我們的日曆程式
document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");
    const modalEl = document.getElementById('courseEditModal');

    if (calendarEl && modalEl) {
        new CalendarManager(calendarEl, modalEl).init();
    }
});