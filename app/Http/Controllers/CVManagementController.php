<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Session;
use Auth;
use App\RegistrationDetails;
use App\PersonalSummary;
use Redirect;
use App\User;
use App\LanguageList;
use App\Country;
use App\CvTable;
use App\HardSkill;
use App\Language;
use App\FurtherEducation;
use App\Subject;
use App\Specialization;
use App\ProfQualTitles;
use App\ProfQual;
use App\ProfBodies;
use App\Industry;
use App\IndustryFunctions;
use App\Currency;
use App\WorkExperience;
use App\WorkExperienceResponsibility;
use App\OtherInterest;
use App\JobAd;
use App\CVManagement;
use Toastr;

class CVManagementController extends Controller
{
    //

    public function candidateCV($id){
       

        $cvdets = CvTable::where('CV_ID', $id)->first();

        //dd($cvdets);
        $details = RegistrationDetails::where('CanditateRegID', $cvdets->CandidateRegID)->first();
           
            //dd($cvdets);
            
            $jobs = JobAd::take(5)->get(); 

            $exps = WorkExperience::where('CV_ID', $cvdets->CV_ID)->get();
            $summary = PersonalSummary::where('CV_ID', $cvdets->CV_ID)->get();
            $y = 0;
            $lang = Language::where('CV_ID', $cvdets->CV_ID)->first();
            if($lang == null){
              $y = 0;
            }else{
            if($lang->Language2 != null){
              $y++;
            }if($lang->Language3 != null){
              $y++;
            }if($lang->Language4 != null){
              $y++;
            }
              
            }
            $attrs = [];
            $skills = [];
            $hskills = [];
            foreach ($summary as $key => $value) {
              array_push($attrs, $value->Attributes);
              array_push($skills, $value->Skills);
              array_push($hskills, $value->HardSkills);
            }
            $languages = LanguageList::orderBy('LanguageName', 'ASC')->get();
            $hardskills = HardSkill::orderBy('Name', 'ASC')->get();

            $education = FurtherEducation::where('CV_ID', $cvdets->CV_ID)->get();
            $subjects = Subject::all();
            $specializations = Specialization::all();
            $profs = ProfQualTitles::all();
            $qualifications = ProfQual::where('CV_ID', $cvdets->CV_ID)->get();

            $profbodies = ProfBodies::where('CV_ID', $cvdets->CV_ID)->get();

            $industry = Industry::all();
            $functions = IndustryFunctions::all();
            $currency = Currency::all();
            $work = WorkExperience::where('CV_ID', $cvdets->CV_ID)->get();
             $managements = CVManagement::where('CV_ID', $cvdets->CV_ID)->get();
            //dd($work);
            $workresps = [];

            foreach ($work as $key => $value) {
                //dd($value);
              $workresps = WorkExperienceResponsibility::where('WorkExpID', $value->WorkExpID)->get();
            }
            $interests = OtherInterest::where('CV_ID', $cvdets->CV_ID)->get();
              
              $countries = Country::all();

            return view('cvmanagements.view', compact('jobs','details','cvdets','languages','summary','hardskills','attrs','skills','hskills','lang','y','subjects','education','specializations','profs','qualifications','profbodies','countries','industry','functions','currency','work','interests','workresps','managements'));
    }


    public function commentCV(Request $request){

        if(!empty($request->input('commentid'))){
         
         $cvman = CVManagement::where('id', $request->input('commentid'))->first();
        $cvman->section = $request->input('section');
        $cvman->comment = $request->input('comment');
        $cvman->staffID = $request->input('staffID');
        $cvman->CV_ID = $request->input('CV_ID');
        $cvman->update();

        }else{
        $cvman = new CVManagement();
        $cvman->section = $request->input('section');
        $cvman->comment = $request->input('comment');
        $cvman->staffID = $request->input('staffID');
        $cvman->CV_ID = $request->input('CV_ID');
        $cvman->save();

        }

        Toastr::success($cvman->section. ' comment has been Updated.');
        return redirect()->back();

    }
}
