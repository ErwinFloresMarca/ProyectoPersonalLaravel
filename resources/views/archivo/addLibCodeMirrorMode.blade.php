@if (isset($cmConfMode))
@switch($cmMode)
    @case('clike')
        <script src="{{asset("plugins/codemirror/mode/clike/clike.js")}}"></script> 
        @break
    @default
        
@endswitch
    
@endif