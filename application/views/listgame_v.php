<? if (isset($games)): ?>
    <table>
        <thead>
        <tr><td>ID</td><td>From</td><td>End</td><td></td></tr>
        </thead>
        <? $i=1; foreach ($games as $row): ?>
            <tr class="<?=(($i%2==0))?'odd':''?> <?=($row->tbdeleted==0?'':'trdelete')?>"
                id="tr<?=$row->id?>"><td><a href="javascript:edit(<?=$row->id?>)"><?=$row->id?></a> </td>
                <td><?=date("H:i d/m/Y",$row->tbdatefrom)?></td>
                <td><?=date("H:i d/m/Y",$row->tbdateto)?></td>
                <td ><input disabled="disabled" type="checkbox" <?=(($row->tbactive==1)?'checked=true':'')?> ></td>
            </tr>
            <? $i++; endforeach; ?>
    </table>
    <div class="pagination">
        <a href="#" class="first" data-action="first">&laquo;</a>
        <a href="#" class="previous" data-action="previous">&lsaquo;</a>
        <input type="text" readonly="readonly" data-max-page="<?=$sumpage?>" />
        <a href="#" class="next" data-action="next">&rsaquo;</a>
        <a href="#" class="last" data-action="last">&raquo;</a>
    </div>
    <script>
    $('.pagination').jqPagination({
        paged: function(page) {
            load(page);
        },
        current_page: <?=$page?>
    });
    </script>
<? endif;