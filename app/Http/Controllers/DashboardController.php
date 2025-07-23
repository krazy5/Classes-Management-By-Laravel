<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeesRecord;
use App\Models\StudentRecord;
use App\Models\Attendance;
use App\Models\FeesChart;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Enquiry;
use App\Models\Event;
use App\Models\Timetable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
         public function index()
        {
            $totalStudents = StudentRecord::count();
            $totalEnquiry = \App\Models\Enquiry::count();
            $totalFeesChart = \App\Models\FeesChart::count();
             // --- START: New Birthday Logic ---
            $today = Carbon::now();

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


                // 1. Get students whose birthday is today
                $todaysBirthdays = StudentRecord::whereMonth('dob', $today->month)
                                                ->whereDay('dob', $today->day)
                                                ->get();

                // 2. Get students with upcoming birthdays in the next 7 days
                $upcomingBirthdays = StudentRecord::whereNotNull('dob')
                    ->orderByRaw("CASE 
                        WHEN MONTH(dob) > MONTH(CURDATE()) OR 
                            (MONTH(dob) = MONTH(CURDATE()) AND DAY(dob) > DAY(CURDATE())) 
                        THEN 0 ELSE 1 END, MONTH(dob), DAY(dob)")
                    ->limit(5) // Get the next 5 upcoming birthdays
                    ->get();

                // --- END: New Birthday Logic ---

                // For the summary cards:
                        $totalTimetables = Timetable::count();
                        $totalEvents = Event::count();

                        // For latest 5 timetables:
                        $timetables = Timetable::with('batch') // eager load batch, if needed
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();

                        // For latest/upcoming 5 events:
                        $upcomingEvents = Event::where('event_date', '>=', now())
                            ->orderBy('event_date')
                            ->limit(5)
                            ->get();


            return view('admin.index', compact(
                'totalStudents',
                'totalEnquiry',
                'totalFeesChart',
                'studentByStd',
                'totalReceivedFees',
                'totalBalanceFees',
                'monthLabels',
                'monthValues',
                'todaysBirthdays',
                'upcomingBirthdays',
                'totalTimetables',
                'timetables',
                'totalEvents',
                'upcomingEvents'
            ));
        }
// ye student ke dashboard ko call karne ka method hai neeche +++++++++++++++++++++++++++++++++++++++++++++++++++
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

                $notifications = Notification::where('is_active', true)
                    ->where(function ($query) use ($student) {
                        $query->where('student_id', $student->id) // sent to this student
                            ->orWhere(function ($q) {
                                $q->whereNull('student_id') // not targeted individually
                                    ->whereIn('audience', ['student', 'all']); // audience matches
                            });
                    })
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();


            $feesRecord = $student->feesRecord; // hasOne relationship

            $feesPaid = 0;
            $feesPending = 0;

            if ($feesRecord) {
                $feesPaid = $feesRecord->received_fees;
                $feesPending = $feesRecord->total_fees - $feesPaid;
            }


            $totalEvents = Event::count();
 // For latest/upcoming 5 events:
                        $upcomingEvents = Event::where('event_date', '>=', now())
                            ->orderBy('event_date')
                            ->limit(5)
                            ->get();

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
                'recentAttendance',
                'notifications',
                'upcomingEvents'
            ));
        }

}
