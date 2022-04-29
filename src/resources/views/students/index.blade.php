@extends('fees::layouts.app')

@section('styles')
<link rel="stylesheet" href="//unpkg.com/view-design/dist/styles/iview.css">
<style>
    [v-cloak]>* {
        display: none;
    }

    [v-cloak]::before {
        content: "loading...";
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-1 px-md-2" id="page_data" v-cloak>
    <div class="card card-body mx-2 mx-md-2">
        <div class="row gx-4 mb-2">
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        Students Fee Management
                    </h5>
                    <p class="mb-0 font-weight-normal text-sm">
                        {{today()->format('l jS \\of F Y')}}
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between">
                            <div class="text-white text-capitalize ps-3">Students</div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Reg Number</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Balance</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, s) in students" :key="s">
                                        <td>
                                            <div class="d-flex px-2 py-1">

                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">Arnold</h6>
                                                    <p class="text-xs text-secondary mb-0">2022</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"></p>

                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success"></span>
                                        </td>

                                        <td class="align-middle d-flex justify-content-around">
                                            <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                Delete
                                            </a>
                                            <a href="#" class="text-info font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
                                                View
                                            </a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="//unpkg.com/view-design/dist/iview.min.js"></script>
<script>
    new Vue({
        created() {
            this.students = JSON.parse('@json($students)');
        },
        el: '#page_data',
        data() {
            return {
                students: [],
                submitting: false,
                addStructure: false,
                dataObj: {
                    course: '',
                    serial_code: '',
                },
                deletingIndex: -1,
                deletingStructure: {},
                delete_confirm: false,
                deleting: false
            }
        },
        methods: {
            year(date) {
                return new Date(date).getFullYear();
            },
            async callApi(method, url, dataObj) {
                try {
                    return await axios({
                        method: method,
                        url: url,
                        data: dataObj
                    });
                } catch (e) {
                    return e.response
                }
            },
        }
    });
</script>
@endsection