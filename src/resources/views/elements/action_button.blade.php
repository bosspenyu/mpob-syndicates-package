@if(in_array("save", $buttons))
<button type="submit"
        class="btn btn-xs btn-primary float-right">
    <i class="fas fa-save"></i> {{ __('Simpan') }}
</button>
@endif

@if(in_array("update", $buttons))
    <button type="submit"
            class="btn btn-xs btn-primary float-right">
        <i class="fas fa-save"></i> {{ __('Kemaskini') }}
    </button>
@endif

@if(in_array("back", $buttons))
<a href="{{ $route }}"
   class="btn btn-xs btn-default btn-xs mx-1 float-right">
    <i class="fas fa-angle-double-left"></i> {{ __('Kembali') }}
</a>
@endif


@if(in_array("edit", $buttons))
<a href="{{ $route  }}"
   class="btn btn-primary btn-xs float-right mx-1">
    <i class="fas fa-edit"></i>
    {{ __('Kemaskini') }}
</a>
@endif

@if(in_array("add", $buttons))
    <a href="{{ $route  }}"
       class="btn btn-primary btn-xs float-right mx-1">
        <i class="fas fa-edit"></i>
        {{ __('Tambah') }}
    </a>
@endif
