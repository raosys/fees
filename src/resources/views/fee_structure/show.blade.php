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
<div class="container-fluid px-1 px-md-2" id="feeEntry" v-cloak v-bind:voteheads="{{$structure->entry_items}}">
    <div class="card card-body mx-2 mx-md-2">
        <div class="row gx-4 mb-2">
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                        View Fee Structure Entries
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
                        <div class="bg-gradient-primary shadow-primary border-radius-lg d-flex justify-content-between pt-4 pb-3">
                            <div class="text-white text-capitalize ps-3 h6">Fees Structure : {{$structure->course[config('fees.course_table_columns')['name']]}}</div>
                            <span class="float-end btn btn-sm btn-success mx-2" @click="addEntry">ADD ENTRY</span>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">S/No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Vote Head</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Amount</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="entry, e in voteheads" :key="e">
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 pl-4">@{{entry.id}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 pl-4">@{{entry.votehead}}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-success ">@{{entry.amount}}</span>
                                        </td>
                                        <td class="align-middle d-flex justify-content-around">
                                            <a href="javascript:;" @click="editEntryItem(entry, e)" class="text-secondary text-info font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                Edit
                                            </a>
                                            <a href="javascript:;" @click="deleteEntry(entry, e)" class="text-danger font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>

                                    <tr class="bg-dark border-radius-lg">
                                        <td colspan="2">
                                            <p class="text-xs text-white font-weight-bold mb-0">Total Amount</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm text-white">KES @{{totalAmount()}}</span>
                                        </td>
                                        <td class="align-middle d-flex justify-content-around"></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Confirm Delete Modal -->
    <Modal v-model="confirm_modal" width="460" :mask-closable="false" :closable="!deleting">
        <p slot="header" style="color: #f60; text-align: center">
            <Icon type="ios-information-circle"></Icon>
            <span>Confirm</span>
        </p>
        <div style="text-align: center">
            <p>Billed Students will still be charged for this entry!</p>
            <p>Proceed?</p>
        </div>
        <div slot="footer">
            <i-button type="success" :loading="deleting" size="large" @click="confirmDelete" long>Continue</i-button>
        </div>
    </Modal>
    <!-- Add Dialogue Box -->
    <Modal v-model="add" :mask-closable="false" :closable="true" :styles="{top:'20px'}" title="Add Entry">
        <i-form ref="newEntry" :model="newEntry" inline>
            <i-form-item prop="votehead">
                <i-input type="text" v-model="newEntry.votehead" placeholder="Tuition Fees" required>
                    <Icon type="ios-person-outline" slot="prepend"></Icon>
                </i-input>
            </i-form-item>
            <br>
            <i-form-item prop="amount">
                <i-input type="number" v-model="newEntry.amount" placeholder="Amount" required>
                    <Icon type="ios-lock-outline" slot="prepend"></Icon>
                </i-input>
            </i-form-item>
        </i-form>

        <div slot="footer">
            <i-button type="error" @click="add = !add" :disabled="submitting" size="small">Cancel</i-button>
            <i-button type="success" :loading="submitting" :disabled="submitting" @click="handleSubmit('newEntry')" size="small">@{{submitting ? 'Saving...' : 'Save'}}</i-button>
        </div>
    </Modal>


    <!-- Edit Dialogue Box -->
    <Modal v-model="edit" :mask-closable="false" :closable="true" :styles="{top:'20px'}" title="Edit Entry">
        <i-form ref="editEntry" :model="editEntry" inline>
            <i-form-item prop="votehead">
                <i-input type="text" v-model="editEntry.votehead" placeholder="Tuition Fees" required>
                    <Icon type="ios-person-outline" slot="prepend"></Icon>
                </i-input>
            </i-form-item>
            <br>
            <i-form-item prop="amount">
                <i-input type="number" v-model="editEntry.amount" placeholder="Amount" required>
                    <Icon type="ios-lock-outline" slot="prepend"></Icon>
                </i-input>
            </i-form-item>
        </i-form>

        <div slot="footer">
            <i-button type="error" @click="edit = !edit" :disabled="submitting" size="small">Cancel</i-button>
            <i-button type="success" :loading="submitting" :disabled="submitting" @click="handleSubmitEdit('editEntry')" size="small">@{{submitting ? 'Saving...' : 'Save'}}</i-button>
        </div>
    </Modal>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="//unpkg.com/view-design/dist/iview.min.js"></script>
<script>
    // import axios from 'axios';
    new Vue({
        el: '#feeEntry',
        created() {
            this.voteheads = JSON.parse('@json($structure->entry_items)');
        },
        data() {
            return {
                edit: false,
                editEntry: {},
                editingIndex: -1,
                submitting: false,
                newEntry: {
                    votehead: '',
                    amount: '',
                    fee_structure_id: '{{$structure->id}}'
                },
                voteheads: [],
                confirm_modal: false,
                deletingEntry: {},
                deletingIndex: -1,
                add: false,
                deleting: false
            }
        },
        methods: {
            async handleSubmitEdit(name) {
                if (this.editEntry.votehead.trim() == "") return this.$Message.error('Fail! Votehead is required');
                if (this.editEntry.amount == "") return this.$Message.error('Fail! Amount is required');
                this.submitting = true;
                const res = await this.callApi('patch', `/fees/entries/${this.editEntry.id}`, this.editEntry);
                if (res.status == 200) {
                    this.voteheads[this.editingIndex] = this.editEntry;
                    this.$Message.success('Success! Entry Updated');
                    this.edit = false;
                    this.editEntry = {};
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
            editEntryItem(entry, index) {
                let obj = {
                    votehead: entry.votehead,
                    amount: entry.amount,
                    id: entry.id
                };
                this.editEntry = obj;
                this.editingIndex = index;
                this.edit = true;
            },
            async confirmDelete() {
                this.deleting = true;
                const res = await this.callApi('delete', `/fees/entries/${this.deletingEntry.id}`);
                if (res.status == 204) {
                    this.voteheads.splice(this.deletingIndex, 1);
                    this.confirm_modal = false;
                    this.deleting = false;
                    this.deletingEntry = {};
                    this.deletingIndex = -1;
                    this.$Message.success('Entry Deleted Succesfully');
                } else {
                    this.$Message.error('Error Occured While Deleting Entry');
                }
            },

            deleteEntry(entry, index) {
                this.deletingEntry = entry;
                this.deletingIndex = index;
                this.confirm_modal = true;
            },
            addEntry() {
                this.add = true;
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
            async handleSubmit(name) {
                if (this.newEntry.votehead.trim() == "") return this.$Message.error('Fail! Votehead is required');
                if (this.newEntry.amount == "") return this.$Message.error('Fail! Amount is required');
                this.submitting = true;
                const res = await this.callApi('post', "{{route('fees.entries.store')}}", this.newEntry);
                if (res.status == 201) {
                    this.voteheads.push(res.data);
                    this.$Message.success('Success!');
                    this.newEntry = {
                        votehead: '',
                        amount: '',
                        fee_structure_id: '{{$structure->id}}'
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
            totalAmount() {
                let total = 0;
                this.voteheads.forEach(entry => {
                    total += parseInt(entry.amount);
                });
                return total;
            }
        },

    });
</script>
@endsection