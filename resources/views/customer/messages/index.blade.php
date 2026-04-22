@extends('customer.layouts.app')

@section('page-content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-extrabold text-slate-800 drop-shadow-sm">
            <i class="fas fa-envelope text-blue-500 mr-2"></i> Kotak Masuk
        </h2>
    </div>

    @if($messages->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-10 text-center flex flex-col items-center">
            <i class="fas fa-envelope-open-text text-5xl text-slate-300 mb-4"></i>
            <h4 class="text-lg font-bold text-slate-600 mb-2">Belum Ada Pesan</h4>
            <p class="text-slate-400 text-sm">Anda belum menerima pesan apapun dari Admin atau Mekanik.</p>
        </div>
    @else
        <div class="bg-white border text-left border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="list-group list-group-flush">
                @foreach($messages as $pesan)
                    <div class="list-group-item list-group-item-action p-4 border-b border-gray-100 hover:bg-slate-50 cursor-pointer relative"
                         onclick="openMessageModal({{ $pesan->id }}, '{{ addslashes($pesan->judul) }}', '{{ addslashes($pesan->isi_pesan) }}', '{{ $pesan->pengirim->name }}', '{{ $pesan->created_at->format('d M Y H:i') }}', {{ $pesan->sudah_dibaca ? 'true' : 'false' }})">
                        
                        <div class="flex justify-between items-start mb-1">
                            <div class="flex items-center space-x-2">
                                @if(!$pesan->sudah_dibaca)
                                    <span class="w-2.5 h-2.5 bg-blue-500 rounded-full inline-block" id="indicator-{{ $pesan->id }}"></span>
                                @endif
                                <h5 class="text-base font-bold {{ $pesan->sudah_dibaca ? 'text-slate-700' : 'text-slate-900' }} mb-0">
                                    {{ $pesan->judul }}
                                </h5>
                            </div>
                            <small class="text-slate-400 text-xs font-semibold">{{ $pesan->created_at->diffForHumans() }}</small>
                        </div>
                        
                        <div class="pl-4">
                            <span class="text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded font-bold uppercase trackind-wide">
                                Dari: {{ $pesan->pengirim->name }} ({{ $pesan->pengirim->role }})
                            </span>
                            <p class="text-sm text-slate-500 mt-2 truncate w-3/4">
                                {{ strip_tags($pesan->isi_pesan) }}
                            </p>
                        </div>
                        
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Filter Modal for reading Message -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered relative">
        <div class="modal-content rounded-xl border-0 shadow-lg relative overflow-hidden">
            <div class="modal-header bg-blue-600 border-0 flex justify-between items-center text-white">
                <h5 class="modal-title font-bold text-lg flex items-center shadow-lg" id="messageModalLabel">
                    <i class="fas fa-envelope-open mr-2"></i> <span id="modal-title-text">Detail Pesan</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-6 bg-slate-50">
                <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-200">
                    <div>
                        <small class="text-slate-400 font-semibold text-[10px] uppercase">PENGIRIM</small>
                        <h6 class="font-bold text-slate-800" id="modal-sender">Administrator</h6>
                    </div>
                    <div class="text-right">
                        <small class="text-slate-400 font-semibold text-[10px] uppercase">TANGGAL</small>
                        <h6 class="font-semibold text-slate-600 text-sm" id="modal-date">10 Jan 2024</h6>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg border border-slate-200 text-slate-700 text-sm whitespace-pre-wrap" id="modal-content">
                    Isi pesan
                </div>
            </div>
            
            <div class="modal-footer bg-slate-100 border-t border-gray-200 flex justify-end">
                <button type="button" class="btn btn-secondary bg-slate-600 hover:bg-slate-700 text-white font-bold rounded shadow-sm text-sm" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let messageModal;
    
    document.addEventListener('DOMContentLoaded', function() {
        if(typeof bootstrap !== 'undefined') {
            messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        }
    });

    function openMessageModal(id, title, content, sender, date, isRead) {
        // Set content
        document.getElementById('modal-title-text').innerText = title;
        document.getElementById('modal-content').innerText = content;
        document.getElementById('modal-sender').innerText = sender;
        document.getElementById('modal-date').innerText = date;
        
        // Open modal
        if (messageModal) {
            messageModal.show();
        } else {
            // fallback if bootstrap js not loaded
            alert(title + "\n\n" + content);
        }

        // Mark as read via AJAX if not read
        if (!isRead) {
            fetch("{{ route('customer.messages.read') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Remove blue dot indicator
                    const indicator = document.getElementById('indicator-' + id);
                    if(indicator) indicator.remove();
                    
                    // Reload softly after a moment to update badges
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                }
            })
            .catch(error => console.error("Error updating message status", error));
        }
    }
</script>
@endpush