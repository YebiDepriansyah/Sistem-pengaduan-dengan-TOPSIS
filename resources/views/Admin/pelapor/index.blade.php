@extends('admin.layout')

@section('title', 'Data Pelapor')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pelapor</h1>
        <a href="{{ route('admin.pelapor.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pelapor
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pelapor</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Unsur</th>
                            <th>Melapor Sebagai</th>
                            <th>Fakultas</th>
                            <th>Email</th>
                            <th>No. WhatsApp</th>
                            <th>Hubungan dengan Korban</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelapor as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama_lengkap }}
                                <div class="small text-muted">{{ $p->nama_panggilan }}</div>
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $p->unsur === 'dosen' ? 'primary' : 
                                    ($p->unsur === 'mahasiswa' ? 'success' : 
                                    ($p->unsur === 'tenaga kependidikan' ? 'info' : 'secondary')) 
                                }}">
                                    {{ ucfirst($p->unsur) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $p->melapor_sebagai === 'korban' ? 'danger' : 
                                    ($p->melapor_sebagai === 'saksi' ? 'info' : 'secondary') 
                                }}">
                                    {{ ucfirst($p->melapor_sebagai) }}
                                </span>
                            </td>
                            <td>
                                {{ $p->fakultas }}
                                @if($p->departemen_prodi)
                                    <div class="small text-muted">{{ $p->departemen_prodi }}</div>
                                @endif
                                @if($p->unit_kerja)
                                    <div class="small text-muted">{{ $p->unit_kerja }}</div>
                                @endif
                            </td>
                            <td>
                                <a href="mailto:{{ $p->email }}" class="text-decoration-none">
                                    {{ $p->email }}
                                </a>
                            </td>
                            <td>
                                <a href="https://wa.me/{{ $p->no_wa }}" target="_blank" class="text-decoration-none">
                                    {{ $p->no_wa }}
                                </a>
                            </td>
                            <td>{{ $p->hubungan_korban ? ucfirst($p->hubungan_korban) : '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.pelapor.show', $p->id_pelapor) }}" 
                                       class="btn btn-info btn-sm"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pelapor.edit', $p->id_pelapor) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.pelapor.destroy', $p->id_pelapor) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pelapor ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush
@endsection 