<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">导入权限</h3>
        <div class="box-tools pull-right">
        </div>
    </div>
    <div class="box-body">
        <div class="box-body fields-group" style="margin-bottom: 20px;">
            <textarea readonly class="form-control" name="" id="displayContainer" cols="30" rows="20"></textarea>
        </div>

        <!-- /.box-body -->
        <div class="box-footer row" style="display: flex">
            <div class="col-md-2">
                <iframe name="hide-frame" style="display: none"></iframe>
                <form action="{{ route('permission-plus.import') }}" method="post" target="hide-frame">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary pull-left"><i class="feather icon-save"></i> 导入权限</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function displayMsg(msg) {
        $('#displayContainer').append(msg + "\n");
        var scrollTop = $("#displayContainer")[0].scrollHeight;
        $('#displayContainer').scrollTop(scrollTop);
    }
</script>
