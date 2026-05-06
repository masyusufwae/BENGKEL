@extends('admin.layouts.app')
@section('title', 'Kalender Servis')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-start gap-4 flex-wrap mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">Kalender Servis</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Klik tanggal untuk melihat note servis, mekanik, work order, dan penggunaan barang.
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.laporan.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">Kembali</a>
                        <a href="{{ route('admin.laporan.index') }}" class="bg-slate-900 hover:bg-slate-700 text-white px-4 py-2 rounded">Buka Form Laporan</a>
                    </div>
                </div>

                <div class="mb-4 text-sm text-gray-600">
                    Periode: {{ $start->format('d/m/Y') }} - {{ $end->format('d/m/Y') }}
                </div>

                <div id="service-calendar" class="bg-white rounded-lg"></div>
            </div>
        </div>
    </div>
</div>

<div id="calendar-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/60 px-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[85vh] overflow-hidden">
        <div class="flex items-center justify-between border-b px-5 py-4">
            <div>
                <h3 class="text-lg font-bold">Detail Servis Tanggal <span id="calendar-modal-date"></span></h3>
                <p class="text-sm text-gray-500">Informasi work order dan barang yang digunakan.</p>
            </div>
            <button type="button" id="calendar-modal-close" class="text-gray-500 hover:text-gray-900 text-2xl leading-none">&times;</button>
        </div>
        <div class="p-5 overflow-y-auto max-h-[calc(85vh-72px)]">
            <div id="calendar-modal-empty" class="hidden text-center text-gray-500 py-10">
                Tidak ada servis pada tanggal ini.
            </div>
            <div id="calendar-modal-content" class="space-y-4"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<style>
    .fc .fc-toolbar-title {
        font-size: 1.4rem;
        font-weight: 700;
    }
    .fc .fc-daygrid-day-top {
        position: relative;
    }
    .calendar-bubble {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 1.4rem;
        height: 1.4rem;
        padding: 0 0.35rem;
        border-radius: 9999px;
        background: #2563eb;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        margin-left: 0.35rem;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notes = @json($calendarNotes);
        const counts = @json($calendarCounts);
        const calendarEl = document.getElementById('service-calendar');
        const modal = document.getElementById('calendar-modal');
        const modalDate = document.getElementById('calendar-modal-date');
        const modalContent = document.getElementById('calendar-modal-content');
        const modalEmpty = document.getElementById('calendar-modal-empty');
        const closeModal = () => modal.classList.add('hidden');

        const escapeHtml = (value) => {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#39;');
        };

        const renderDateNotes = (dateStr) => {
            const items = notes[dateStr] || [];
            modalDate.textContent = dateStr;
            modalContent.innerHTML = '';

            if (!items.length) {
                modalEmpty.classList.remove('hidden');
                return;
            }

            modalEmpty.classList.add('hidden');

            items.forEach((item) => {
                const servis = (item.servis || []).map((row) => `
                    <li>${escapeHtml(row.nama)} - Rp ${Number(row.harga).toLocaleString('id-ID')}</li>
                `).join('');
                const parts = (item.sparepart || []).map((row) => `
                    <li>${escapeHtml(row.nama)} x${escapeHtml(row.jumlah)} - Rp ${Number(row.subtotal).toLocaleString('id-ID')}</li>
                `).join('');

                const el = document.createElement('div');
                el.className = 'border rounded-lg p-4 bg-slate-50';
                el.innerHTML = `
                    <div class="flex items-start justify-between gap-4 flex-wrap mb-3">
                        <div>
                            <p class="font-bold text-slate-900">${escapeHtml(item.nomor_wo)}</p>
                            <p class="text-sm text-slate-600">Mekanik: ${escapeHtml(item.mekanik)}</p>
                            <p class="text-sm text-slate-600">Customer: ${escapeHtml(item.customer)}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-500">${escapeHtml(item.tanggal)}</p>
                            <p class="font-semibold text-blue-700">Rp ${Number(item.total).toLocaleString('id-ID')}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="font-semibold mb-1">Servis</p>
                            <ul class="list-disc ml-5 space-y-1 text-sm">${servis || '<li>Tidak ada servis</li>'}</ul>
                        </div>
                        <div>
                            <p class="font-semibold mb-1">Sparepart</p>
                            <ul class="list-disc ml-5 space-y-1 text-sm">${parts || '<li>Tidak ada sparepart</li>'}</ul>
                        </div>
                    </div>
                    <div class="mt-3 text-sm text-slate-700">
                        <p class="font-semibold">Keluhan</p>
                        <p>${escapeHtml(item.keluhan)}</p>
                    </div>
                `;
                modalContent.appendChild(el);
            });
        };

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            firstDay: 1,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            dateClick(info) {
                modal.classList.remove('hidden');
                renderDateNotes(info.dateStr);
            },
            dayCellDidMount(arg) {
                const dateStr = [
                    arg.date.getFullYear(),
                    String(arg.date.getMonth() + 1).padStart(2, '0'),
                    String(arg.date.getDate()).padStart(2, '0')
                ].join('-');
                const count = counts[dateStr] || 0;
                if (count > 0) {
                    const top = arg.el.querySelector('.fc-daygrid-day-top');
                    if (top && !top.querySelector('.calendar-bubble')) {
                        const bubble = document.createElement('span');
                        bubble.className = 'calendar-bubble';
                        bubble.textContent = count;
                        top.appendChild(bubble);
                    }
                }
            }
        });

        calendar.render();

        document.getElementById('calendar-modal-close').addEventListener('click', closeModal);
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>
@endsection
