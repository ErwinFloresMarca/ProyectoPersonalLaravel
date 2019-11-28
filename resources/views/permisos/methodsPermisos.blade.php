
<script>
    function onClickPermisosVer(id,val){
        $.ajax({
            url: '{{url("permisos")}}'+'/'+id,
            headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            type: 'PUT',
            dataType:'json',
            data:{
                ver:(1-val),
                editar:null
            },
            success:function(docs){
                toastr.success(docs.msn,docs.title);
            }
        });
        reloadDataTable();
    }
    function onClickPermisosEditar(id,val){
        $.ajax({
            url: '{{url("permisos")}}'+'/'+id,
            headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            type: 'PUT',
            dataType:'json',
            data:{
                ver:null,
                editar:(1-val)
            },
            success:function(docs){
                toastr.success(docs.msn,docs.title);
            }
        });
        reloadDataTable();
    }
</script>