@extends('adminlte::page')

@section('title', 'Create an employee')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1 class="mr-3 text-dark">Create an employee</h1>
    </div>
@stop

@section('plugins.BsCustomFileInput', true)
@section('plugins.Select2', true)
@section('plugins.TempusDominusBs4', true)

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <form id="create-employee" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                {{-- Photo --}}
                                <img id="avatar" src="#" alt="your avatar" class="object-fit-cover"/>
                                <x-adminlte-input-file id="image" name="image" label="Photo" accept=".jpg, .png"
                                    placeholder="Choose a file..." legend="Browse" value="{{ old('image') }}">
                                    <x-slot name="bottomSlot">
                                        <span class="text-sm text-gray">
                                            File format jpg, png up to 5MB, the minimum size of 300x300px
                                        </span>
                                    </x-slot>
                                </x-adminlte-input-file>
                                {{-- Name --}}
                                <x-adminlte-input id="name" name="name" label="Name" placeholder="Enter name of employee"
                                    min="2" max="256" error-key="name" value="{{ old('name') }}">
                                    <x-slot name="bottomSlot">
                                        @error('name')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @else
                                            <span id="simbol-count" class="text-sm text-gray float-right">
                                                0/256
                                            </span>
                                        @enderror
                                    </x-slot>
                                </x-adminlte-input>
                                {{-- Phone --}}
                                <x-adminlte-input id="phone" name="phone" label="Phone" placeholder="Enter phone of employee"
                                    type="tel" error-key="phone" value="{{ old('phone') }}">
                                    <x-slot name="bottomSlot">
                                        @error('phone')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @else
                                            <span id="simbol-count" class="text-sm text-gray float-right">
                                                Required format +380 (xx) XXX XX XX
                                            </span>
                                        @enderror
                                    </x-slot>
                                </x-adminlte-input>
                                {{-- Email --}}
                                <x-adminlte-input id="email" name="email" label="Email" placeholder="Enter email of employee"
                                    error-key="email" value="{{ old('email') }}">
                                    <x-slot name="bottomSlot">
                                        @error('email')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </x-slot>
                                </x-adminlte-input>
                                {{-- Position --}}
                                <x-adminlte-select2 name="position_id" label="Position" data-placeholder="Select position..."
                                    error-key="position_id" id="position_id">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-dark">
                                            <i class="fa-solid fa-briefcase"></i>
                                        </div>
                                    </x-slot>
                                    <option></option>
                                    @forelse ($positions as $position)
                                        <option @if (old('position_id')==$position->id) selected @endif
                                            value="{{ $position->id }}" >{{ $position->name }}</option>
                                    @empty
                                        <option disabled>No positions available</option>
                                    @endforelse
                                </x-adminlte-select2>
                                {{-- Salary --}}
                                <x-adminlte-input id="salary" name="salary" label="Salary, $" placeholder="Enter salary of employee"
                                    min="0" max="500" error-key="salary" value="{{ old('salary') }}" type="number" step="0.001">
                                    <x-slot name="bottomSlot">
                                        @error('salary')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </x-slot>
                                </x-adminlte-input>
                                {{-- Head --}}
                                <x-adminlte-input id="head" name="head" label="Head" placeholder="Enter head name of employee"
                                    error-key="head" value="{{ old('head') }}">
                                    <x-slot name="bottomSlot">
                                        @error('head')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </x-slot>
                                </x-adminlte-input>
                                <input type="hidden" id='head_id' name="head_id" value="{{ old('head_id') }}">
                                {{-- Date of employment --}}
                                @php
                                $dateOfEmployeeConfig = [
                                    'format' => 'DD.MM.YYYY',
                                    'dayViewHeaderFormat' => 'MMM YYYY',
                                    'minDate' => "js:moment().startOf('month')",
                                    'maxDate' => "js:moment().endOf('month')",
                                    'daysOfWeekDisabled' => [0, 6],
                                ];
                                @endphp
                                <x-adminlte-input-date name="date_of_employment" label="Date of employment"
                                    :config="$dateOfEmployeeConfig" placeholder="Choose a day..."
                                    value="{{ old('date_of_employment') }}">
                                    <x-slot name="appendSlot">
                                        <div class="input-group-text bg-dark">
                                            <i class="fas fa-calendar-day"></i>
                                        </div>
                                    </x-slot>
                                    <x-slot name="bottomSlot">
                                        @error('date_of_employment')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </x-slot>
                                </x-adminlte-input-date>

                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('employees.index') }}" class="btn btn-default">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    $(document).ready(function($) {
        image.onchange = evt => {
            const [file] = image.files;
            if (file) {
                avatar.src = URL.createObjectURL(file);
            }
        }

        var name = document.getElementById('name');
        name.oninput = function() {
            document.getElementById('simbol-count').innerHTML = name.value.length+'/256';
        };

        jQuery(function($){
            $('#phone').mask('+380 (99) 999 99 99', {placeholder:" "}, {autoclear: false});
        });

        $("#create-employee").submit(function(event) {
            event.preventDefault();
            $("#phone").val($("#phone").val().replace(/\(|\)|\s/g, ''));
            this.submit();
        });

        var routeGetHead = "{{ route('employees.get-head') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#head").autocomplete({
            source: function( request, response ) {
                var selectedPosition = $('#select2-position_id-container').html();
                var positionId = $('#position_id option:contains('+selectedPosition+')').val();
                // Fetch data
                $.ajax({
                    url: routeGetHead,
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        head: request.term,
                        position_id: positionId,
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                // Set selection
                $('#head').val(ui.item.label); // display the selected text
                $('#head_id').val(ui.item.value); // save selected id to input
                return false;
            }
        });
    });
</script>
@endpush
