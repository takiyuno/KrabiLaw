<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legisexpense extends Model
{
    protected $table = 'legisexpenses';
    protected $primaryKey = 'id';
    protected $fillable = [ 'id','legislation_id','Date_expense','Type_expense','Topic_expense','Amount_expense','Note_expense',
                            'Contract_expense','Code_expense','Flag_expense','Useradd_expense','Useredit_expense','Receiptno_expense',
                            'NameApprove_expense','DateApprove_expense','LawyerName_expense',
                            'Transfer_expense','PayAmount_expense','BalanceAmount_expense'];


    public function ExpenseTolegislation()
    {
        return $this->belongsTo(Legislation::class,'legislation_id','id');
    }

    public function ExpenseTolegiscourt()
    {
        return $this->belongsTo(Legiscourt::class,'legislation_id','legislation_id');
    }

    public function ExpenseToExhibit()
    {
        return $this->belongsTo(Legisexhibit::class,'Contract_expense','Contract_legis');
    }
}
