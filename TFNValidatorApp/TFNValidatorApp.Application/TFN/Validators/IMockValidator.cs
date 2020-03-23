using TFNValidatorApp.Application.TFN.ViewModels;

namespace TFNValidatorApp.Application.TFN.Validators
{
    public interface IMockValidator
    {
        ValidationResultViewModel MockValidateAlwaysTrue();
        ValidationResultViewModel MockValidateAlwaysFalse();
    }
}
