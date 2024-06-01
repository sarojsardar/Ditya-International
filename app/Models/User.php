<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Candidat\MedicalCheckup;
use App\Models\Medical\Medical;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'mobile_no',
        'password',
        'user_type',
        'code',
        'status',
        'reference_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function userInfo(){
        return $this->hasOne(UserInformation::class, 'user_id');
    }

    public function languages(){
        return $this->hasOne(LanguageDetail::class, 'user_id');
    }

    public function categories(){
        return $this->hasOne(CategoryDetail::class, 'category_id');
    }


    // New developed for the many to many relationship with pivot table
    public function manyCategories(){
        return $this->belongsToMany(Category::class, 'category_details', 'user_id', 'category_id');
    }
    public function manyLanguages(){
        return $this->belongsToMany(Language::class, 'language_details', 'user_id', 'language_name');
    }

    public function educations(){
        return $this->hasMany(EducationalDocument::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'user_id');
    }

    public function companyInfo(){
        return $this->hasOne(Company::class, 'user_id');
    }

    public function candidates(){
        return $this->hasMany(Candidate::class, 'pro_id');
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function bankDetail()
    {
        return $this->hasOne(BankDetail::class);
    }

    /**
     * Educational qualifications relationship (one-to-many)
     */

    /**
     * Passport details relationship (one-to-one)
     */
    public function passportDetail()
    {
        return $this->hasOne(PassportDetail::class);
    }

    /**
     * Work experience relationship (one-to-many)
     */
    public function workExperience()
    {
        return $this->hasMany(WorkExperience::class);
    }


    /**
     * Language details relationship (one-to-many)
     */

    public function uploadPhoto()
    {
        return $this->hasOne(UploadPhoto::class);
    }
    public function resumeDetail()
    {
        return $this->hasOne(ResumeDetail::class);
    }

    public function languageDetail() {
        return $this->hasMany(LanguageDetail::class);
    }

    // This relationship depends on how CategoryDetail is related to the User
    // Assuming a One-to-Many relationship for demonstration
    public function categoryDetail()
    {
        return $this->hasMany(CategoryDetail::class);
    }

    public function educationalQualification()
    {
        return $this->hasOne(EducationalDocument::class);
    }


    public function candidateCompany()
    {
        return $this->hasOne(CompanyCandidate::class); // Use hasMany if a user can have multiple company associations
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }


    public function interviews():HasMany
    {
        return $this->hasMany(Interview::class, 'user_id');
    }

    //  user type MEDICAL_OFFICER and the user role is Medical Officer
    public function medicals():BelongsToMany
    {
        return $this->belongsToMany(Medical::class, 'medical_officer', 'user_id', 'medical_id');
    }

    // if user type is candidate and is in checkup status
    public function medicalCheckup():HasMany
    {
        return $this->hasMany(MedicalCheckup::class, 'user_id');
    }


}
