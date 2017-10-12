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
            <div class="col-m-12"><h2>Upload your data contract</h2></div>
        </div>
        <section id="app" is="data-contract-create" inline-template :submit_url="'{{$submit_url}}'"
             :scrape_url="'{{route('scrape')}}'" :redirect_url="'{{$redirect_url}}'">
                    <section>
                        <div class="row">
                            <div class="col-m-3">
                    <span>Data contract name</span>
                            </div>
                            <div class="col-m-3">
                    <input type="text" name="name" v-model="dc.name" class="form-control"/>
                            </div>
                        </div>
                    <p></p>
                    <section v-for="(task, task_index) in dc.tasks">
                        <div class="row">
                            <div class="col-m-2">
                                Task type is
                            </div>
                            <div class="col-m-5">
                                @{{task.type}} <button v-on:click="removeTask(task_index)">X</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-m-2">
                        Task target url:
                            </div>
                            <div class="col-m-5">
                                <input type="text" name="target_url" v-model="dc.tasks[task_index].targetURL"/>
                        <button v-on:click="openTargetUrl(dc.tasks[task_index])">Rerieve target URL</button>
                            </div>
                        </div>
                            <p></p>
                        <div class="row">
                            <div class="col-m-6">
                                <div class="container" v-for="(d, d_index) in task.data">
                                    <div class="row">
                                        <div class="col-m-4">
                                            Data label name :
                                        </div>
                                        <div class="col-m-4">
                                            <input type="text" v-model="task.data[d_index].key"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-m-4">
                                            Data xpath:
                                        </div>
                                        <div class="col-m-4">
                                        <input type="text" v-model="task.data[d_index].value" v-bind:name="'xpath_'+d_index"/>
                                        <button v-on:click="removeDataItemFortask(task, d_index)">X</button>
                                        <button v-on:click="openModalForXpath(task, d_index)">Get Xpath</button>
                                        </div>
                                    </div>
                                    <p></p>
                                </div>

                                <button v-on:click="addEmptyDataItemFortask(task)">Add data item</button>
                            </div>
                            <div class="col-m-6">
                                Urls
                                <div v-for="(u, u_index) in task.urls">
                                    Url : <input type="text" name="url_name" v-model="task.urls[u_index]"/>
                                    <button v-on:click="removeUrlFortask(task, u_index)">X</button>
                                    <button v-on:click="openModalForUrlXpath(task, u_index)">Get Xpath</button><br><br><br><br>
                                </div><br>
                                <button v-on:click="addEmptyUrlItemFortask(task)">Add Url item</button>
                            </div>
                        </div>
                        </section>
                        <br><br><br>
                        <button v-on:click="addTask('GetData')">Add 'GetData' task</button>
                        <button v-on:click="addTask('GetUrls')">Add 'GetUrls' task</button>
                        <br><br>
                        <button class="btn btn-primary pull-right mt-15" v-on:click="submit">
                            Add contract
                        </button>

                    </section>
        </section>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Target URL page</h4>
                </div>
                <div class="modal-body container">
                    <p>Click on 'Rerieve target URL' first to retreive TargetURL page content</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection
