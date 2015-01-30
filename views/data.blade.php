{!! $paginator->render() !!}
<div id="log" class="well">
    @if($log)
        <?php $c = 1; ?>
        @foreach($log as $l)
            <div class="alert">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="log log-{{ $l['level'] }}">
                            <h4 class="panel-title">
                                @if($l['stack'] !== "\n")
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $c }}" >
                                @endif
                                {{ $l['header'] }}
                                </a>
                            </h4>
                        </div>
                        @if($l['stack'] !== "\n")
                        <div id="collapse-{{ $c }}" class="panel-collapse collapse">
                            <div class="panel-body">
                                <pre>
                                    {{ $l['stack'] }}
                                </pre>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <?php $c++; ?>
        @endforeach
    @else
        <div class="alert alert-danger">There are no log entries within these constraints.</div>
    @endif
</div>
{!! $paginator->render() !!}
