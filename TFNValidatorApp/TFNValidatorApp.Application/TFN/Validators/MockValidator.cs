using TFNValidatorApp.Application.TFN.ViewModels;

namespace TFNValidatorApp.Application.TFN.Validators
{
    public class MockValidator : IMockValidator
    {
        public ValidationResultViewModel MockValidateAlwaysTrue()
        {
            return new ValidationResultViewModel
            {
                Status = true,
                Message = "Valid TFN"
            };
        }

        public ValidationResultViewModel MockValidateAlwaysFalse()
        {
            return new ValidationResultViewModel
            {
                Status = false,
                Message = "Invalid TFN"
            };
        }
    }
}
