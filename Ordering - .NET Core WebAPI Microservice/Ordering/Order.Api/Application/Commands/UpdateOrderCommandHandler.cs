using System;
using System.Threading.Tasks;
using System.Threading;
using MediatR;
using Ordering.Domain.Models;
using Ordering.Domain.Exceptions;
using Ordering.Domain.Models.ProductAggregate;
using Ordering.Domain.Models.OrderAggregate;

namespace Ordering.Api.Application.Commands
{
    public class UpdateOrderCommandHandler : IRequestHandler<UpdateOrderCommand, bool>
    {
        private readonly IRepository<Product> _productRepository;
        private readonly IRepository<Order> _orderRepository;

        public UpdateOrderCommandHandler(IRepository<Order> orderRepository, IRepository<Product> productRepository)
        {
            _orderRepository = orderRepository ?? throw new ArgumentNullException(nameof(orderRepository));
            _productRepository = productRepository ?? throw new ArgumentNullException(nameof(productRepository));
        }

        public async Task<bool> Handle(UpdateOrderCommand request, CancellationToken cancellationToken)
        {
            var product = _productRepository.GetAsync(request.ProductId);

            if (product == null)
                throw new OrderDomainException("The order product does not exist.");

            var order = await _orderRepository.GetAsync(request.Id);

            if (order == null)
                throw new OrderDomainException("The Order does not exist.");

            if (order != null)
            {
                order.Update(request.ProductId, request.OrderDate, request.Description);

                _orderRepository.Update(order);
                await _orderRepository.UnitOfWork.SaveEntitiesAsync();

                return true;
            }

            return false;
        }
    }
}
