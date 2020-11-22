<div class="simple_notify">
    <div class="modal-headline" style="text-align: right;">
        <i ng-if="$pop.contents.result" class="material-icons" style="font-size:36px; color:green; padding:5px;">done_all</i>
        <i ng-if="! $pop.contents.result" class="material-icons" style="font-size:36px; color:red; padding:5px;">error_outline</i>
    </div>
    <div class="modal-body text-kufi text-rtl">
        {{$pop.contents.message}}

    </div>
    <div class="modal-footer">
        <button class="btn btn-outline-success" ng-click="$pop.ok()">OK</button>
    </div>
</div>
