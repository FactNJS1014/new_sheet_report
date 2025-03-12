import { createRouter , createWebHistory } from "vue-router";
import form from "@/components/ReportForm.vue"
import report_include from "@/components/IncludeReport.vue"
import report_choose from "@/components/ReportChoose.vue"
const routes = [
    {
        path: '/',
        component: form,
        name: 'index',
    },
    {
        path: '/choose',
        component: report_include,
        name: 'choose',
    },
    {
        path: '/report',
        component: report_choose,
        name: 'report',
    }
   
]

const router = createRouter({
    history: createWebHistory('/new_sheet_report'),
    routes,
})

export default router;