using System;
using System.Threading.Tasks;
using System.Threading;
using MediatR;
using Ordering.Domain.Models;
using Ordering.Domain.Exceptions;
using Ordering.Domain.Models.ProductAggregate;

namespace Ordering.Api.Application.Commands
{
    public class UpdateProductCommandHandler : IRequestHandler<UpdateProductCommand, bool>
    {
        private readonly IRepository<Product> _productRepository;

        public UpdateProductCommandHandler(IRepository<Product> productRepository)
        {
            _productRepository = productRepository ?? throw new ArgumentNullException(nameof(productRepository));
        }

        public async Task<bool> Handle(UpdateProductCommand request, CancellationToken cancellationToken)
        {
            var product = await _productRepository.GetAsync(request.Id);

            if (product == null)
            {
                throw new OrderDomainException("The product does not exist.");
            }

            if (product != null)
            {
                product.Update(request.Name, request.Description, request.Price);

                _productRepository.Update(product);
                await _productRepository.UnitOfWork.SaveEntitiesAsync();

                return true;
            }

            return false;
        }
    }
}
