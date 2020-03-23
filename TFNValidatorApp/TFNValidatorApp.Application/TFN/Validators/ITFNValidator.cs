using System;
using System.Collections.Generic;
using System.Text;
using System.Threading.Tasks;
using TFNValidatorApp.Application.TFN.ViewModels;

namespace TFNValidatorApp.Application.TFN.Validators
{
    public interface ITFNValidator
    {
        ValidationResultViewModel Validate(string tfn, List<string> validationAttemptsList);
    }
}
