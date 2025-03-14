<template>
    <div class="flex justify-center mt-5">
        <div class="w-full p-3 rounded bg-slate-100">
            <div class="grid grid-cols-2">
                <div class="flex flex-col">
                    <div class="join">
                        <p class="w-full p-5 text-xl font-semibold text-blue-800 bg-blue-100 join-item">ชื่อเอกสาร:</p>
                        <p class="w-full p-5 text-xl font-semibold text-blue-800 bg-white join-item">{{ name }}</p>
                    </div>
                    <div class="mt-2 join">
                        <p class="w-full p-5 text-xl font-semibold text-blue-800 bg-blue-100 join-item">หมายเลขเอกสาร:
                        </p>
                        <p class="w-full p-5 text-xl font-semibold text-blue-800 bg-white join-item">{{ hid }}</p>
                    </div>
                    <div class="mt-2 join">
                        <p class="w-full p-5 text-xl font-semibold text-blue-800 bg-blue-100 join-item">เวอร์ชัน:</p>
                        <p class="w-full p-5 text-xl font-semibold text-blue-800 bg-white join-item">{{ rev }}</p>
                    </div>
                    <div class="mt-2 join">
                        <p class="w-full p-5 text-xl font-semibold text-blue-800 bg-blue-100 join-item">หมายเลข:</p>
                        <p class="w-full p-5 text-xl font-semibold text-blue-800 bg-white join-item">{{ rid }}</p>
                    </div>


                </div>
                <div class="flex flex-col ms-5">
                    <p class="text-xl font-semibold">อนุมัติโดย:</p>
                    <div class="mt-3 bg-white">
                        <DataTable :value="results" stripedRows tableStyle="min-width: 50rem"
                            class="text-lg font-medium">
                            <Column field="APPRLOG_APPRLEVEL" header="ลำดับ"></Column>
                            <Column field="APPRLOG_EMPID" header="รหัส"></Column>
                            <Column field="USERS_EMPNAME" header="ชื่อผู้อนุมัติ"></Column>
                            <Column header="วันที่อนุมัติ">
                                <template #body="{ data }">
                                    {{ formatDate(data.APPRLOG_LSTDT) }}
                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
            </div>
            <div class="w-full mt-5 overflow-x-auto border border-base-content/25">
                <DataTable :value="details" showGridlines tableStyle="min-width: 50rem" class="text-lg font-medium"
                    paginator :rows="50" :rowsPerPageOptions="[50,100]" scrollable scrollHeight="500px">
                    <template #header>
                        <div class="pb-4 text-end">
                            <Button @click="exportExcel()"
                                class="text-xl font-semibold text-white btn btn-success"> <i class="pi pi-external-link"></i>Export Excel</Button>
                        </div>
                    </template>
                    <Column field="LNNO" header="ลำดับ">
                    </Column>
                    <Column field="DESC1" header="รายละเอียด" style="min-width: 400px;"></Column>
                    <Column field="DESC2" header="วิธีการ" style="min-width: 400px;"></Column>
                    <Column field="DESC3" header="มาตรฐาน" style="min-width: 500px;"></Column>
                    <Column field="TOOLS" header="เครื่องมือ" style="min-width: 200px;"></Column>
                    <Column field="ANSWER" header="คำตอบ" style="min-width: 200px;"></Column>
                    <Column header="ผลลัพธ์" style="min-width: 200px;" >
                        <template #body="{ data }">
                            <span class="text-lg font-semibold text-green-500">{{ data.RESULT }}</span>
                        </template>
                    </Column>
                    <Column header="Status" style="min-width: 100px;">
                        <template #body="{ data }">
                            <span v-if="data.RESULT"><span class="icon-[material-symbols-light--check-circle] size-9 text-green-500"></span></span>
                        </template>
                    </Column>
                    <Column field="EMPNAME" header="ชื่อผู้ตรวจสอบ" style="min-width: 200px;"></Column>
                    <Column field="SHIFT" header="กะงาน" style="min-width: 200px;"></Column>
                    <Column field="LINE" header="ไลน์" style="min-width: 200px;"></Column>
                    <Column field="MC" header="หมายเลขเครื่องจักร" style="min-width: 200px;"></Column>
                    <Column header="วันที่ตรวจสอบ" style="min-width: 200px;">
                        <template #body="{ data }">
                            {{ formatDate(data.DATE) }}
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import { useDateFormat } from '@vueuse/core';
import * as XLSX from 'xlsx';
import 'primeicons/primeicons.css';

import Button from 'primevue/button';

export default {
    data() {
        return {
            doc_id: '',
            results: [],
            details: [],
            document: [],
            name: '',
            DocName: '',
            hid: '',
            rev: '',
            rid: '',

        }

    },
    mounted() {
        this.fetchResults()
    },
    methods: {
        fetchResults() {
            const id = localStorage.getItem('docID');
            const name = localStorage.getItem('docName');
            if (id && name) {
                this.doc_id = JSON.parse(id)
                this.name = JSON.parse(name)
                // console.log(this.name)
                // console.log(this.doc_id)
                axios.post('/new_sheet_report/send/report', {
                    doc_id: this.doc_id,
                    name: this.name,
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then((res) => {
                    this.results = res.data.results;
                    this.details = res.data.details;
                    this.DocName = res.data.name;
                    this.hid = this.details[0].HID;
                    this.rev = this.details[0].REV;
                    this.rid = this.details[0].RID;
                    //console.log(this.results)
                    //console.log(this.details)

                }).catch((err) => {
                    console.log(err)
                })
            }
        },
        formatDate(date) {
            if (!date) return '-'; // Handle empty dates
            return useDateFormat(date, 'DD/MM/YYYY').value;
        },
        exportExcel() {
          

            // Define the mapping between JSON field names and table headers
            const fieldMapping = {
                "LNNO": "ลำดับ",
                "DESC1": "รายละเอียด",
                "DESC2": "วิธีการ",
                "DESC3": "มาตรฐาน",
                "TOOLS": "เครื่องมือ",
                "ANSWER": "คำตอบ",
                "RESULT": "ผลลัพธ์",
                "EMPNAME": "ชื่อผู้ตรวจสอบ",
                "SHIFT": "กะงาน",
                "LINE": "ไลน์",
                "MC": "หมายเลขเครื่องจักร",
                "DATE": "วันที่ตรวจสอบ"
            };

            // Map the data fields to the headers
            const mappedData = this.details.map(item => {
                const mappedItem = {};
                for (const key in item) {
                    if (fieldMapping[key]) {
                        mappedItem[fieldMapping[key]] = item[key];
                        
                    }
                    
                }
                //console.log(mappedItem)
                return mappedItem;
            });
            //console.log(mappedData);

            // Create a new worksheet with the mapped data
            const worksheet = XLSX.utils.json_to_sheet(mappedData);

            // Create a new workbook and append the worksheet
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

            // Generate the current date in YYYY-MM-DD format
            const currentDate = new Date().toISOString().split('T')[0]; // "YYYY-MM-DD" format

            // Set the filename with the current date
            const filename = `exported_data_${currentDate}.xlsx`;

            // Save the file with the generated filename
            XLSX.writeFile(workbook, filename);
        }
    }
}
</script>