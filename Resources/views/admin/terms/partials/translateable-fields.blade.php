<div class="box-body">
    {!! Form::i18nInput('name', trans('taxonomy::terms.form.name'), $errors, $lang, $term, ['data-slug' => 'source']) !!}
    <div class='form-group{{ $errors->has("{$lang}.slug") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[slug]", trans('taxonomy::terms.form.slug')) !!}
        {!! Form::text("{$lang}[slug]", old("{$lang}.slug", !empty($term) ? $term->translate($lang)->slug : null), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('taxonomy::terms.form.slug')]) !!}
        {!! $errors->first("{$lang}.slug", '<span class="help-block">:message</span>') !!}
    </div>
    {!! Form::i18nTextarea('description', trans('taxonomy::terms.form.description'), $errors, $lang, $term) !!}

    <div class="box-group" id="accordion">
        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
        <div class="panel box box-primary">
            <div class="box-header">
                <h4 class="box-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo-{{$lang}}">
                        {{ trans('taxonomy::terms.form.meta_data') }}
                    </a>
                </h4>
            </div>
            <div style="height: 0px;" id="collapseTwo-{{$lang}}" class="panel-collapse collapse">
                <div class="box-body">
                    <div class='form-group{{ $errors->has("{$lang}[meta_title]") ? ' has-error' : '' }}'>
                        {!! Form::label("{$lang}[meta_title]", trans('taxonomy::terms.form.meta_title')) !!}
                        {!! Form::text("{$lang}[meta_title]", old("$lang.meta_title"), ['class' => "form-control", 'placeholder' => trans('taxonomy::terms.form.meta_title')]) !!}
                        {!! $errors->first("{$lang}[meta_title]", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class='form-group{{ $errors->has("{$lang}[meta_description]") ? ' has-error' : '' }}'>
                        {!! Form::label("{$lang}[meta_description]", trans('taxonomy::terms.form.meta_description')) !!}
                        <textarea class="form-control" name="{{$lang}}[meta_description]" rows="10" cols="80">{{ old("$lang.meta_description") }}</textarea>
                        {!! $errors->first("{$lang}[meta_description]", '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="panel box box-primary">
            <div class="box-header">
                <h4 class="box-title">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFacebook-{{$lang}}">
                        {{ trans('taxonomy::terms.form.facebook_data') }}
                    </a>
                </h4>
            </div>
            <div style="height: 0px;" id="collapseFacebook-{{$lang}}" class="panel-collapse collapse">
                <div class="box-body">
                    <div class='form-group{{ $errors->has("{$lang}[og_title]") ? ' has-error' : '' }}'>
                        {!! Form::label("{$lang}[og_title]", trans('taxonomy::terms.form.og_title')) !!}
                        {!! Form::text("{$lang}[og_title]", old("{$lang}.og_title"), ['class' => "form-control", 'placeholder' => trans('taxonomy::terms.form.og_title')]) !!}
                        {!! $errors->first("{$lang}[og_title]", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class='form-group{{ $errors->has("{$lang}[og_description]") ? ' has-error' : '' }}'>
                        {!! Form::label("{$lang}[og_description]", trans('taxonomy::terms.form.og_description')) !!}
                        <textarea class="form-control" name="{{$lang}}[og_description]" rows="10" cols="80">{{ old("$lang.og_description") }}</textarea>
                        {!! $errors->first("{$lang}[og_description]", '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group{{ $errors->has("{$lang}[og_type]") ? ' has-error' : '' }}">
                        <label>{{ trans('taxonomy::terms.form.og_type') }}</label>
                        <select class="form-control" name="{{ $lang }}[og_type]">
                            <option value="website" {{ old("$lang.og_type") == 'website' ? 'selected' : '' }}>{{ trans('taxonomy::terms.facebook-types.website') }}</option>
                            <option value="product" {{ old("$lang.og_type") == 'product' ? 'selected' : '' }}>{{ trans('taxonomy::terms.facebook-types.product') }}</option>
                            <option value="article" {{ old("$lang.og_type") == 'article' ? 'selected' : '' }}>{{ trans('taxonomy::terms.facebook-types.article') }}</option>
                            <option value="category" {{ old("$lang.og_type") == 'category' ? 'selected' : '' }}>{{ trans('taxonomy::terms.facebook-types.category') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
