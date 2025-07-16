<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeesRecord;
use App\Models\StudentRecord;
use App\Models\Attendance;
use App\Models\FeesChart;
use Illuminate\Support\Facades\Auth;
use App\Models\Enquiry;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
         public function index()
        {
            $totalStudents = StudentRecord::count();
            $totalEnquiry = \App\Models\Enquiry::count();
            $totalFeesChart = \App\Models\FeesChart::count();

            $studentByStd = StudentRecord::select('std', DB::raw('count(*) as total'))
                                    ->groupBy('std')
                                    ->pluck('total', 'std');

            $totalReceivedFees = FeesRecord::sum('received_fees');
            $totalBalanceFees = FeesRecord::sum('balance_fees');

            $monthlyEnquiries = \App\Models\Enquiry::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

            $monthLabels = [];
            $monthValues = [];

            for ($i = 1; $i <= 12; $i++) {
                $monthLabels[] = Carbon::create()->month($i)->format('M');
                $monthValues[] = $monthlyEnquiries->get($i, 0);
            }

            return view('admin.index', compact(
                'totalStudents',
                'totalEnquiry',
                'totalFeesChart',
                'studentByStd',
                'totalReceivedFees',
                'totalBalanceFees',
                'monthLabels',
                'monthValues'
            ));
        }

         public function showStudentIndex()
        {
            $totalStudents = StudentRecord::count();
            $totalEnquiry = \App\Models\Enquiry::count();
            $totalFeesChart = \App\Models\FeesChart::count();

            $studentByStd = StudentRecord::select('std', DB::raw('count(*) as total'))
                                    ->groupBy('std')
                                    ->pluck('total', 'std');

            $totalReceivedFees = FeesRecord::sum('received_fees');
            $totalBalanceFees = FeesRecord::sum('balance_fees');

            $monthlyEnquiries = \App\Models\Enquiry::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

            $monthLabels = [];
            $monthValues = [];

            for ($i = 1; $i <= 12; $i++) {
                $monthLabels[] = Carbon::create()->month($i)->format('M');
                $monthValues[] = $monthlyEnquiries->get($i, 0);
            }
            $recentAttendance = Attendance::where('student_id', auth()->guard('student')->user()->id)->latest()->take(5)->get();
            $student = Auth::guard('student')->user();

            $feesRecord = $student->feesRecord; // hasOne relationship

            $feesPaid = 0;
            $feesPending = 0;

            if ($feesRecord) {
                $feesPaid = $feesRecord->received_fees;
                $feesPending = $feesRecord->total_fees - $feesPaid;
            }
            return view('students.student_dashboard', compact(
                'totalStudents',
                'totalEnquiry',
                'totalFeesChart',
                'studentByStd',
                'totalReceivedFees',
                'totalBalanceFees',
                'monthLabels',
                'monthValues',
                'feesPaid',
                'feesPending',
                'recentAttendance'
            ));
        }

}
