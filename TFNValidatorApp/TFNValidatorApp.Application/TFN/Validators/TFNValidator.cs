using System;
using System.Collections.Generic;
using System.Linq;
using System.Text.RegularExpressions;
using TFNValidatorApp.Application.TFN.ViewModels;

namespace TFNValidatorApp.Application.TFN.Validators
{
    public class TFNValidator : ITFNValidator
    {
        private readonly ILinkedAttemptsValidator _linkedAttemptsValidator;
        private static readonly int[] eightDigitWeightingFactors = { 10, 7, 8, 4, 6, 3, 5, 1 };
        private static readonly int[] nineDigitWeightingFactors = { 10, 7, 8, 4, 6, 3, 5, 2, 1 };
        private const int divider = 11;

        public TFNValidator(ILinkedAttemptsValidator linkedAttemptsValidator)
        {
            _linkedAttemptsValidator = linkedAttemptsValidator ?? throw new ArgumentNullException(nameof(linkedAttemptsValidator));
        }

        public ValidationResultViewModel Validate(string tfn, List<string> validationAttemptsList)
        {
            if(validationAttemptsList.Count >= 3)
            {
                if(_linkedAttemptsValidator.CheckForLinkedValidationAttempts(validationAttemptsList))
                {
                    return new ValidationResultViewModel
                    {
                        Status = false,
                        Message = "Similar Validation Attempts Detected! Please try again after 30 seconds."
                    };
                }
            }

            if (tfn == null || tfn == "")
            {
                return new ValidationResultViewModel
                {
                    Status = false,
                    Message = "TFN is Required"
                };
            }

            tfn = Regex.Replace(tfn, @"\s+", "");

            if (!ValidateTFNFormat(tfn))
            {
                return new ValidationResultViewModel
                {
                    Status = false,
                    Message = "TFN should be numeric and only have 8 or 9 digits"
                };
            }

            if (!ValidateTFN(tfn))
            {
                return new ValidationResultViewModel
                {
                    Status = false,
                    Message = "Invalid TFN"
                };
            }

            return new ValidationResultViewModel
            {
                Status = true,
                Message = "Valid TFN"
            }; 
        }

        private bool ValidateTFNFormat(string tfn)
        {
            return Regex.IsMatch(tfn, @"^\d{8,9}$");
        }

        private bool ValidateTFN(string tfn)
        {
            int sum = 0;
            int[] weightingFactors = tfn.Length == 8 ? eightDigitWeightingFactors : nineDigitWeightingFactors;

            sum = tfn.Select((value, index) =>  int.Parse(value.ToString()) * weightingFactors[index]).Sum();

            return sum % divider == 0 ? true : false; 
        }
    }
}
