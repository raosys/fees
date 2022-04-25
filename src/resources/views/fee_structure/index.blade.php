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
                        Create, Edit and modify fee structure
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
                            <div class="text-white text-capitalize ps-3">Fees Structure</div>
                            <span class="float-end btn btn-sm btn-success mx-2" @click="addStructure = !addStructure"> ADD NEW</span>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Year</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Serial Code</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(structure, i) in structures" :key="i">
                                        <td>
                                            <div class="d-flex px-2 py-1">

                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">@{{structure.course[course_columns['short_name']]}}</h6>
                                                    <p class="text-xs text-secondary mb-0">@{{structure.course[course_columns['name']]}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">@{{year(structure.created_at)}}</p>

                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">@{{structure.status}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">@{{structure.serial_code}}</span>
                                        </td>
                                        <td class="align-middle d-flex justify-content-around">
                                            <a href="javascript:;" @click="attemptDelete(structure, i)" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                Delete
                                            </a>
                                            <a :href="link(structure)" class="text-info font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit">
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
    <!-- Add Dialogue Box -->
    <Modal v-model="addStructure" :mask-closable="false" :closable="true" :styles="{top:'20px'}" title="Create Fee Structure">
        <i-form ref="dataObj" :model="dataObj" inline>
            <i-form-item prop="course">
                <i-select v-model="dataObj.course" placeholder="Course" prefix="ios-bookmarks-outline" required>
                    <i-option v-for="(course, c) in courses" :value="course.id" :key="c">@{{course[course_columns['name']]}}</i-option>
                </i-select>
            </i-form-item>
            <br>
            <br>
            <i-form-item prop="serial_code">
                <i-input type="text" v-model="dataObj.serial_code" placeholder="Serial Number" required>
                    <Icon type="ios-person-outline" slot="prepend"></Icon>
                </i-input>
            </i-form-item>
        </i-form>

        <div slot="footer">
            <i-button type="error" @click="addStructure = !addStructure" :disabled="submitting" size="small">Cancel</i-button>
            <i-button type="success" :loading="submitting" :disabled="submitting" @click="handleSubmit('dataObj')" size="small">@{{submitting ? 'Saving...' : 'Save'}}</i-button>
        </div>
    </Modal>

    <!-- Confirm Delete Modal -->
    <Modal v-model="delete_confirm" width="460" :mask-closable="false" :closable="!deleting">
        <p slot="header" style="color: #f60; text-align: center">
            <Icon type="ios-information-circle"></Icon>
            <span>Confirm</span>
        </p>
        <div style="text-align: center">
            <p>Billed Students wont be affected, Unbilled Students Wont be billed using this fee structure</p>
            <p>Proceed?</p>
        </div>
        <div slot="footer">
            <i-button type="success" :loading="deleting" size="large" @click="confirmDelete" long>Continue</i-button>
        </div>
    </Modal>
</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="//unpkg.com/view-design/dist/iview.min.js"></script>
<script>
    new Vue({
        created() {
            this.courses = JSON.parse('@json($courses)');
            this.structures = JSON.parse('@json($fee_structures)');
            this.course_columns = JSON.parse('@json($columns)');
        },
        el: '#page_data',
        data() {
            return {
                courses: [],
                structures: [],
                course_columns: [],
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
            async confirmDelete() {
                this.deleting = true;
                const res = await this.callApi('delete', `/fees/structure/${this.deletingStructure.id}`);
                if (res.status == 204) {
                    this.structures.splice(this.deletingIndex, 1);
                    this.delete_confirm = false;
                    this.deletingStructure = {};
                    this.deletingIndex = -1;
                    this.$Message.success('Fee Structure Deleted Succesfully');
                } else {
                    this.$Message.error('Error Occured While Deleting Fee Structure');

                }
                this.deleting = false;
            },
            attemptDelete(structure, i) {
                this.deletingIndex = i;
                this.deletingStructure = structure;
                this.delete_confirm = true;
            },
            async handleSubmit(name) {
                if (this.dataObj.course == "") return this.$Message.error('Fail! course is required');
                if (this.dataObj.serial_code.trim() == "") return this.$Message.error('Fail! serial_code is required');
                this.submitting = true;
                const res = await this.callApi('post', "{{route('fees.structure.store')}}", this.dataObj);
                if (res.status == 201) {
                    this.structures.push(res.data);
                    this.$Message.success('Success!');
                    this.dataObj = {
                        course: '',
                        serial_code: '',
                    };
                } else {
                    if (res.status == 422) {
                        for (let i in res.data.errors) {
                            this.$Message.error(res.data.errors[i][0])
                        }
                    } else {
                        this.$Message.error('Something Went Wrong')
                    }
                }
                this.submitting = false;
            },
            link(structure) {
                return '/fees/structure/' + structure.id;
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