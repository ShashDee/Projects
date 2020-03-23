using System;
using System.Collections.Generic;
using System.Text;

namespace TFNValidatorApp.Application.TFN.Validators
{
    public interface ILinkedAttemptsValidator
    {
        bool CheckForLinkedValidationAttempts(List<string> validationAttempts);
    }
}
