using Microsoft.Extensions.DependencyInjection;
using TFNValidatorApp.Application.TFN.Validators;

namespace TFNValidatorApp.Application
{
    public static class DependencyInjection
    {
        public static IServiceCollection AddApplication(this IServiceCollection services)
        {
            services.AddTransient<ILinkedAttemptsValidator, LinkedAttemptsValidator>();
            services.AddTransient<ITFNValidator, TFNValidator>();
            services.AddTransient<IMockValidator, MockValidator>();

            return services;
        }
    }
}
