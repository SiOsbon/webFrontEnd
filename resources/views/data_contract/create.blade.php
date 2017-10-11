@extends('layouts.app_admin')

@section('content')
    <div class="container">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <div class="row flash-message flash-message-{{ $msg }} col-md-8 col-md-offset-2">
                    {{ Session::get('alert-' . $msg) }}
                </div>
            @endif
        @endforeach
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body" id="app" is="data-contract-create" inline-template :submit_url="'{{$submit_url}}'"
                        :scrape_url="'{{route('scrape')}}'" :redirect_url="'{{$redirect_url}}'">
                        <div>
                            <span>Data contract name</span>
                            <input type="text" name="name" v-model="dc.name" class="form-control"/>
                            <br>
                            <div v-for="(task, task_index) in dc.tasks">
                                Task type is: @{{task.type}} <button v-on:click="removeTask(task_index)">X</button><br>
                                Task target url: <input type="text" name="target_url" v-model="dc.tasks[task_index].targetURL"/>
                                <button v-on:click="openTargetUrl(dc.tasks[task_index])">Rerieve target URL</button>
                                <div class="row">
                                    <div class="col-md-6">
                                        Data
                                        <div v-for="(d, d_index) in task.data">
                                            Data label name : <input type="text" v-model="task.data[d_index].key"/><br>
                                            Data xpath: <input type="text" v-model="task.data[d_index].value"
                                                               v-bind:name="'xpath_'+d_index"/>
                                            <button v-on:click="removeDataItemFortask(task, d_index)">X</button>
                                            <button v-on:click="openModalForXpath(task, d_index)">Get Xpath</button><br><br>
                                        </div><br>
                                        <button v-on:click="addEmptyDataItemFortask(task)">Add data item</button>
                                    </div>
                                    <div class="col-md-6">
                                        Urls
                                        <div v-for="(u, u_index) in task.urls">
                                            Url : <input type="text" name="url_name" v-model="task.urls[u_index]"/>
                                            <button v-on:click="removeUrlFortask(task, u_index)">X</button>
                                            <button v-on:click="openModalForUrlXpath(task, u_index)">Get Xpath</button><br><br><br><br>
                                        </div><br>
                                        <button v-on:click="addEmptyUrlItemFortask(task)">Add Url item</button>
                                    </div>
                                </div>
                                <br><br>
                            </div>
                            <br><br><br>
                            <button v-on:click="addTask('GetData')">Add 'GetData' task</button>
                            <button v-on:click="addTask('GetUrls')">Add 'GetUrls' task</button>
                            <br><br>
                            <button class="btn btn-primary pull-right mt-15" v-on:click="submit">
                                Add contract
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Click on 'Rerieve target URL' first to retreive TargetURL page content</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection
