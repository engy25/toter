
<?php $i=0; ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="data-table2" class="table border p-0 text-nowrap mb-0">
                <thead class="tabel-row-heading text-dark">
                    <tr style="background:#f4f5f7">
                        <th class="fw-semibold border-bottom">ID</th>
                        <th class="fw-semibold border-bottom">{{ trans('words.name') }}</th>
                        <th class="fw-semibold border-bottom">{{ trans('words.image') }}</th>
                        <th class="fw-semibold border-bottom">{{ trans('words.discount_percentage') }}</th>
                        <th class="fw-semibold border-bottom">{{ trans('words.expire_date') }}</th>
                        <th class="bg-transparent fw-semibold border-bottom">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offers as $offer)
                        <tr>
                            <td><span class="text-dark fs-13 fw-semibold">{{ $i++ }}</span></td>
                            <td><span class="text-dark fs-13 fw-semibold">
                                    @if ($offer->translations->isNotEmpty())
                                        {{ $offer->translations[0]->name }}
                                    @else
                                        {{ $offer->name }}
                                    @endif
                                </span>
                            </td>
                            <td><img src="{{ asset($offer->image) }}" alt="offer Image" style="height: 50% ; width:50%" class="img-fluid"></td>
                            <td><span class="text-dark fs-13 fw-semibold">{{ $offer->discount_percentage }}</span></td>
                            <td><span class="text-dark fs-13 fw-semibold">{{ $offer->to_date }}</span></td>
                            <td class="center align-middle">
                                <div class="btn-group">
                                    <a href="{{ route('offers.edit', $offer->id) }}" class="btn bg-info-transparent d-flex align-items-center justify-content-center">
                                        <i style="font-size: 20px;" class="fe fe-edit text-info "></i>
                                    </a>
                                    <a href="{{ LaravelLocalization::localizeURL(route('offers.edit', $offer->id)) }}" class="btn btn-info btn-icon py-1 me-2" title="Edit" style="width: 100px; height: 40px;">
                                        {{ trans('words.edit') }} <i class="bi bi-pencil-square fs-16"></i>
                                    </a>
                                    <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-success show-offer" style="width: 100px; height: 40px;">
                                        <i class="bi bi-eye"></i> {{ trans('words.show') }}
                                    </a>&nbsp;&nbsp;
                                    <button type="button" class="btn btn-danger delete-offer" data-id="{{ $offer->id }}" style="width: 100px; height: 40px;">
                                        <i class="bi bi-trash-fill"></i> {{ trans('words.delete') }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                @if ($offers->lastPage() > 1)
                    {{ $offers->links('pagination.simple-bootstrap-4') }}
                @endif
            </div>
