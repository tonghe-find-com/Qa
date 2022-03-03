@extends('core::admin.master')

@section('title', __('qas'))

@section('content')

<item-list
    url-base="/api/qas"
    locale="{{ config('typicms.content_locale') }}"
    fields="id,status,title"
    table="qas"
    title="qas"
    include=""
    appends=""
    :exportable="false"
    :searchable="['title']"
    :sorting="['title_translated']">

    <template slot="add-button" v-if="$can('create qas')">
        @include('core::admin._button-create', ['module' => 'qas'])
    </template>

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="checkbox" v-if="$can('update qas')||$can('delete qas')"></item-list-column-header>
        <item-list-column-header name="edit" v-if="$can('update qas')"></item-list-column-header>
        <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
        <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td class="checkbox" v-if="$can('update qas')||$can('delete qas')"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>
        <td v-if="$can('update qas')">@include('core::admin._button-edit', ['module' => 'qas'])</td>
        <td><item-list-status-button :model="model"></item-list-status-button></td>
        <td v-html="model.title_translated"></td>
    </template>

</item-list>

@endsection
