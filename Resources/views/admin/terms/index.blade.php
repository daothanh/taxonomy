@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('taxonomy::terms.title.terms') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.taxonomy.vocabulary.index') }}">{{ trans('taxonomy::taxonomies.title.taxonomies') }}</a></li>
        <li><a href="{{ route('admin.taxonomy.vocabulary.edit', [$vocabulary->id]) }}">{{ $vocabulary->name }}</a></li>
        <li class="active">{{ trans('taxonomy::terms.title.terms') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.taxonomy.term.create',['vocabulary' => $vocabulary->id]) }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('taxonomy::terms.button.create term') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th data-sortable="false">{{ trans('taxonomy::terms.table.name') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.thumbnail') }}</th>
                                <th data-sortable="false">{{ trans('taxonomy::terms.table.status') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($terms)): ?>
                            <?php foreach ($terms as $term): ?>
                            <tr>
                                <td><a href="{{ route('admin.taxonomy.term.edit', ['vocabulary' => $vocabulary->id, 'term' => $term->id]) }}">{{ str_repeat('-', $term->depth)." ".$term->name }}</a></td>
                                <td>@if($term->featured_image)<img src="@thumbnail($term->featured_image->path, 'smallThumb')" alt="{{ $term->name }}" />@endif</td>
                                <td>
                                    {{ $term->status ? trans('taxonomy::terms.form.show') : trans('taxonomy::terms.form.hide') }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.taxonomy.term.edit', ['vocabulary' => $vocabulary->id, 'term' => $term->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.taxonomy.term.destroy', ['vocabulary' => $vocabulary->id, 'term' => $term->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th data-sortable="false">{{ trans('taxonomy::terms.table.name') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.thumbnail') }}</th>
                                <th data-sortable="false">{{ trans('taxonomy::terms.table.status') }}</th>
                                <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('taxonomy::terms.title.create term') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.taxonomy.term.create', [$vocabulary->id]) ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": false,
                "lengthChange": true,
                "filter": false,
                "sort": false,
                "info": false,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@endpush
