<template>
    <div class="flex justify-center mt-5">
        <div class="w-full p-3 rounded bg-slate-100">
            <DataTable :value="datashow" tableStyle="min-width: 50rem" showGridlines paginator :rows="10"
                :rowsPerPageOptions="[5, 10, 20, 50]">
                <Column field="GroupID" header="หมายเลขเอกสาร" sortable></Column>
                <Column field="DocRID" header="หมายเลขคำตอบ" sortable></Column>
                <Column field="DocName" header="ชื่อเอกสาร" sortable></Column>
                <Column field="ProdLineNo" header="หมายเลขไลน์ผลิต" sortable></Column>
                <Column field="DocDate" header="วันที่เอกสาร" sortable></Column>
                <Column field="Approve" header="ลำดับการอนุมัติ" sortable></Column>
                <Column field="CompleteFlag" header="สถานะเอกสาร" sortable>
                    <template #body="{ data }">
                        <span v-if="data.CompleteFlag == 1" class="text-lg font-medium text-green-500">อนุมัติ</span>
                        <span v-else class="text-lg font-medium text-red-500">ยังไม่อนุมัติ</span>
                    </template>
                </Column>


                <Column header="Actions" class="w-24 !text-end">
                    <template #body="{ data }">
                        <Button @click="handleClick(data.DocRID, data.DocName)" class="btn btn-accent">View</Button>
                    </template>
                </Column>
            </DataTable>

        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useDateFormat } from '@vueuse/core';
import { body } from '@primeuix/themes/aura/card';

import Button from 'primevue/button';

export default {

    data() {
        return {
            forms: {
                zone: '',
                line: '',
                pshift: '',
                date: '',
            },
            datashow: [],
        };
    },
    mounted() {
        this.fetchDataShow();

    },
    methods: {
        fetchDataShow() {
            // ดึงข้อมูลจาก localStorage
            const data = localStorage.getItem("form");
            //console.log(data)
            if (data) {
                this.forms = JSON.parse(data);
               // console.log(this.forms)
                axios.post('/new_sheet_report/send/show', {
                    forms: this.forms, // ส่ง params ตรง ๆ 
                    header: {
                        'Content-Type': 'application/json',
                    }

                }).then((res) => {
                    //console.log(res.data);
                    this.datashow = res.data;
                    //console.log(this.datashow);
                }).catch((error) => {
                    console.error("Error fetching data:", error);
                });
            }

        },
        handleClick(DocRID, DocName) {
            //console.log("DocRID:", DocRID);
            localStorage.setItem("docID", JSON.stringify(DocRID));
            localStorage.setItem("docName", JSON.stringify(DocName));
            this.$router.push("/report");
        },
        formatDate(date) {
            if (!date) return '-'; // Handle empty dates
            return useDateFormat(date, 'DD/MM/YYYY').value;
        },
        getDataTables() {
            // ตั้งค่า datatable
            $('#table').DataTable();
        }

    },
};
</script>